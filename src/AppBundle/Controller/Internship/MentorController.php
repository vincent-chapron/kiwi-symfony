<?php

namespace AppBundle\Controller\Internship;

use AppBundle\Entity\Internship\Internship;
use AppBundle\Entity\Internship\Mentor;
use AppBundle\Form\Internship\InternshipType;
use AppBundle\Form\Internship\MentorType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MentorController extends FOSRestController
{
    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("mentor", class="AppBundle\Entity\Internship\Mentor")
     * @param Mentor $mentor
     * @return Mentor
     */
    public function getMentorAction(Mentor $mentor)
    {
        return $mentor;
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships"
     * )
     *
     * @param Request $request
     * @return Mentor
     * @throw BadRequestHttpException
     */
    public function postMentorAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Mentor(), MentorType::class);
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("mentor", class="AppBundle\Entity\Internship\Mentor")
     * @param Request $request
     * @param Mentor $mentor
     * @return Mentor
     * @throw BadRequestHttpException
     */
    public function putMentorAction(Request $request, Mentor $mentor) {
        return $this->get('data_provider')
            ->createOrUpdate($request, $mentor, MentorType::class);
    }
}
