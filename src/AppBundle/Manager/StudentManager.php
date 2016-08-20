<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Presence\Historic;
use AppBundle\Entity\Student;
use Doctrine\ORM\EntityManager;

class StudentManager {
    protected $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
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
}
