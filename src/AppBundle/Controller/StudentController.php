<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StudentController extends FOSRestController
{
    /**
     * Get all students.
     * @ApiDoc(
     *      resource = false,
     *      section = "Students",
     *      description = "Get all students.",
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
     * Get all students.
     * @ApiDoc(
     *      resource = false,
     *      section = "Students",
     *      description = "Get a specific student.",
     *      statusCodes = {
     *          200 = "Success, return a student.",
     *          404 = "Error, Student not found."
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("student", class="AppBundle\Entity\Student")
     * @param Student $student
     * @return Student
     */
    public function getStudentAction(Student $student)
    {
        return $student;
    }
}
