<?php

namespace AppBundle\Controller\Course;

use AppBundle\Entity\Course\Course;
use AppBundle\Entity\Course\Note;
use AppBundle\Entity\Course\Result;
use AppBundle\Entity\Internship\Internship;
use AppBundle\Form\Course\CourseType;
use AppBundle\Form\Course\NoteType;
use AppBundle\Form\Course\ResultType;
use AppBundle\Form\Internship\InternshipType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ResultController extends FOSRestController
{
    /**
     * Création d'un résultat pour un étudiant sur un certain controle, ou une certaine note.
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses"
     * )
     *
     * @param Request $request
     * @return Result
     * @throw BadRequestHttpException
     */
    public function postResultAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Result(), ResultType::class);
    }

    /**
     * Modification d'un résultat.
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("result", class="AppBundle\Entity\Course\Result")
     * @param Request $request
     * @param Result $result
     * @return Result
     * @throw BadRequestHttpException
     */
    public function putResultAction(Request $request, Result $result) {
        return $this->get('data_provider')
            ->createOrUpdate($request, $result, ResultType::class);
    }

    /**
     * Suppression d'un résultat.
     * @ApiDoc(
     *      resource = false,
     *      section = "Courses",
     *      requirements = {
     *          { "name" = "result", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default"})
     * @ParamConverter("beacon", class="AppBundle\Entity\Course\Result")
     * @param Result $result
     * @return Result
     */
    public function deleteBeaconAction(Result $result) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($result);
        $em->flush();

        return $result;
    }
}
