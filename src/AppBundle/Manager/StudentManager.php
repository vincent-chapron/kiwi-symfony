<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Presence\Historic;
use AppBundle\Entity\Student;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;

class StudentManager {
    protected $manager;
    protected $userManager;
    protected $mailer;

    public function __construct(EntityManager $manager, UserManager $userManager, \Swift_Mailer $mailer)
    {
        $this->manager = $manager;
        $this->userManager = $userManager;
        $this->mailer = $mailer;
    }

    public function getStudents()
    {
        $student_manager = $this->manager->getRepository('AppBundle:Student');
        $students = $student_manager->findAll();

        return $students;
    }

    public function addPresence(Student $student)
    {
        if ($year = $student->getPromotion()->getCurrentYear()) {
            // TODO: GERER LES EXCEPTIONS: PAR EXEMPLE LES PERIODES DE VACANCES ...
            // TODO: VERIFIER SI LA PRESENCE N'EST PAS DEJA CREER. UTILISER LE REPOSITORY DES PRESENCE ?

            $presence = new Historic();
            $presence->setStudent($student);

            $this->manager->persist($presence);
            $this->manager->flush();
        }
    }

    public function createStudent(Student $student)
    {
        // TODO: VERIFIER SI IL N'EXISTE PAS DEJA

        $this->manager->persist($student);
        $this->manager->flush();

        $username = $this->generateStudentUsername($student->getForenames(), $student->getLastname());
        $password = $this->generateStudentPassword();

        $user = new User();
        $user->setEnabled(true);
        $user->addRole("ROLE_STUDENT");
        $user->setEmail($student->getEmail());
        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setStudent($student);

        $this->addPresence($student);

        $this->userManager->updateUser($user);

        $mail = \Swift_Message::newInstance()
            ->setSubject("Votre nouveau compte KIWI")
            ->setFrom("vincent@chapron.io")                                 // TODO CHANGER L'ADRESSE MAIL
            ->setTo($student->getEmail())
            ->setContentType('text/html')
            ->setBody("<h1>Nouveau compte kiwi</h1>
Un nouveau compte à été créer, vos identifiants sont les suivants:

<ul>
    <li>username: <strong>$username</strong></li>
    <li>password: <strong>$password</strong></li>
</ul>");
        $this->mailer->send($mail);
    }

    public function generateStudentUsername($forenames, $lastname) {
        $f = strtolower(substr($forenames, 0, 1));
        $l = str_split(implode('_', array_map(function($name) {return strtolower($name);}, explode(' ', $lastname))));
        $available_characters = "abcdefghijklmnopqrstuvwxyz";

        $username = "";
        for($i = 0; strlen($username) < 6 && count($l) > $i; $i++) {
            $c = $l[$i];
            if (strrpos($available_characters, $c) !== false) {
                $username .= $c;
            }
        }
        $username .= "_$f";

        return $username;
    }

    public function generateStudentPassword() {
        $password = "";
        $available_characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $arr = str_split($available_characters);

        for ($i = 0; $i < 10; $i++) {
            $password .= $arr[array_rand($arr)];
        }

        return $password;
    }
}
