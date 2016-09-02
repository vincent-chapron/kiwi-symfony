<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Entity\User;
use AppBundle\Form\StudentType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StudentController extends FOSRestController
{
    /**
     * Récupération de son profil.
     * @ApiDoc(
     *      resource = false,
     *      section = "Students"
     * )
     *
     * @View(serializerGroups={"Default", "Student", "Me"})
     * @return Student
     */
    public function getMeAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
        return $user->getStudent();
    }

    /**
     * Récupération des étudiants.
     * @ApiDoc(
     *      resource = false,
     *      section = "Students",
     *      statusCodes = {
     *          200 = "Success, return array of students."
     *      }
     * )
     *
     * @View(serializerGroups={"Default"})
     * @return ArrayCollection<Student>
     */
    public function getStudentsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $student_repository = $em->getRepository('AppBundle:Student');
        $students = $student_repository->findAll();

        return $students;
    }

    /**
     * Récupération d'un étudiant particulier.
     * @ApiDoc(
     *      resource = false,
     *      section = "Students",
     *      statusCodes = {
     *          200 = "Success, return a student.",
     *          404 = "Error, Student not found."
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Student"})
     * @ParamConverter("student", class="AppBundle\Entity\Student")
     * @param Student $student
     * @return Student
     */
    public function getStudentAction(Student $student)
    {
        return $student;
    }

    /**
     * Récupération des stages d'un étudiant particulier.
     * @ApiDoc(
     *      resource = false,
     *      section = "Students",
     *      statusCodes = {
     *          200 = "Success, return a student.",
     *          404 = "Error, Student not found."
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Student"})
     * @ParamConverter("student", class="AppBundle\Entity\Student")
     * @param Student $student
     * @return ArrayCollection<Internship>
     */
    public function getStudentsInternshipsAction(Student $student)
    {
        return $student->getInternships();
    }

    /**
     * Création d'un étudiant.
     * @ApiDoc(
     *      resource = false,
     *      section = "Students"
     * )
     *
     * @View(serializerGroups={"Default", "Student"})
     * @param Request $request
     * @return Student
     */
    public function postStudentsAction(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $studentManager = $this->get('student_manager');
            $studentManager->createStudent($student);

            return $student;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
    }

    /**
     * Modification d'un étudiant.
     * @ApiDoc(
     *      resource = false,
     *      section = "Students",
     *      requirements = {
     *          { "name" = "student", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Student"})
     * @ParamConverter("student", class="AppBundle\Entity\Student")
     * @param Request $request
     * @param Student $student
     * @return Student
     * @throw BadRequestHttpException
     */
    public function putStudentsAction(Request $request, Student $student) {
        $form = $this->createForm(StudentType::class, $student);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();                                   //TODO UPDATE LE USER EGALEMENT

            return $student;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
    }

    // TODO: ACTION POUR LE MDP
}
