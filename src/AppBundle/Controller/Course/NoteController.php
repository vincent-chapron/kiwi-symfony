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

        $statistics = [
            "min"       => null,
            "max"       => null,
            "average"   => null
        ];

        foreach ($results as $result) {
            /** @var Result $result */
            $value = $result->getResult();

            if ($statistics["min"] === null)
                $statistics["min"] = $value;
            else if ($statistics["min"] > $value)
                $statistics["min"] = $value;

            if ($statistics["max"] === null)
                $statistics["max"] = $value;
            else if ($statistics["max"] < $value)
                $statistics["max"] = $value;

            if ($statistics["average"] === null)
                $statistics["average"] = $value;
            else
                $statistics["average"] += $value;
        }

        if ($statistics["average"] !== null) $statistics["average"] /= count($results);

        return $statistics;
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
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            return $note;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
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
        $form = $this->createForm(NoteType::class, $note);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $note;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
    }
}
