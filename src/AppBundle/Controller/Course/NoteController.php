<?php

namespace AppBundle\Controller\Course;

use AppBundle\Entity\Course\Course;
use AppBundle\Entity\Course\Note;
use AppBundle\Entity\Course\Result;
use AppBundle\Entity\Internship\Internship;
use AppBundle\Form\Course\CourseType;
use AppBundle\Form\Course\NoteType;
use AppBundle\Form\Internship\InternshipType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class NoteController extends FOSRestController
{
    /**
     * Récupération des résultats d'un controle ou autres notes.
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses",
     *      requirements = {
     *          { "name" = "note", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default"})
     * @param $note
     * @return array
     */
    public function getNoteStatisticsAction($note)
    {
        $em = $this->getDoctrine()->getManager();
        $result_repository = $em->getRepository('AppBundle:Course\Result');
        $results = $result_repository->findByNote($note);

        return $this->get('statistics_provider')->getStatistics($results);
    }

    /**
     * Récupération des résultats d'un controle ou autres notes.
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses",
     *      requirements = {
     *          { "name" = "note", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default"})
     * @param $note
     * @return ArrayCollection<Result>
     */
    public function getNoteResultsAction($note)
    {
        $em = $this->getDoctrine()->getManager();
        $result_repository = $em->getRepository('AppBundle:Course\Result');
        $results = $result_repository->findByNote($note);

        return $results;
    }

    /**
     * Création d'une note, une note représente un controle ou une participation oral par exemple.
     * Elle permet d'avoir un bareme, le coefficient ...
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses"
     * )
     *
     * @param Request $request
     * @return Note
     * @throw BadRequestHttpException
     */
    public function postNoteAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Note(), NoteType::class);
    }

    /**
     * Modification d'une note.
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("note", class="AppBundle\Entity\Course\Course")
     * @param Request $request
     * @param Note $note
     * @return Note
     * @throw BadRequestHttpException
     */
    public function putNoteAction(Request $request, Note $note) {
        return $this->get('data_provider')
            ->createOrUpdate($request, $note, NoteType::class);
    }
}
