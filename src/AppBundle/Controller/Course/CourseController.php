<?php

namespace AppBundle\Controller\Course;

use AppBundle\Entity\Course\Course;
use AppBundle\Entity\Internship\Internship;
use AppBundle\Form\Course\CourseType;
use AppBundle\Form\Internship\InternshipType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CourseController extends FOSRestController
{
    /**
     * Récupération des notes d'un cours.
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses",
     *      requirements = {
     *          { "name" = "course", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default"})
     * @param $course
     * @return ArrayCollection<Note>
     */
    public function getCourseNotesAction($course)
    {
        $em = $this->getDoctrine()->getManager();
        $note_repository = $em->getRepository('AppBundle:Course\Note');
        $notes = $note_repository->findByCourse($course);

        return $notes;
    }

    /**
     * Création d'un cours, un cours permet de regrouper des notes par matière.
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses"
     * )
     *
     * @param Request $request
     * @return Course
     * @throw BadRequestHttpException
     */
    public function postCourseAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Course(), CourseType::class);
    }

    /**
     * Modification d'un cours.
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("course", class="AppBundle\Entity\Course\Course")
     * @param Request $request
     * @param Course $course
     * @return Course
     * @throw BadRequestHttpException
     */
    public function putCoursesAction(Request $request, Course $course) {
        return $this->get('data_provider')
            ->createOrUpdate($request, $course, CourseType::class);
    }
}
