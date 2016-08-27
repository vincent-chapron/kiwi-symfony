<?php

namespace AppBundle\Controller\Internship;

use AppBundle\Entity\Internship\FollowUp;
use AppBundle\Entity\Internship\Internship;
use AppBundle\Form\Internship\FollowUpType;
use AppBundle\Form\Internship\InternshipType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FollowUpController extends FOSRestController
{
    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("follow_up", class="AppBundle\Entity\Internship\FollowUp")
     * @param FollowUp $follow_up
     * @return FollowUp
     */
    public function getFollowupAction(FollowUp $follow_up)
    {
        return $follow_up;
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships"
     * )
     *
     * @param Request $request
     * @return FollowUp
     * @throw BadRequestHttpException
     */
    public function postFollowupAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new FollowUp(), FollowUpType::class);
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("follow_up", class="AppBundle\Entity\Internship\FollowUp")
     * @param Request $request
     * @param FollowUp $follow_up
     * @return FollowUp
     * @throw BadRequestHttpException
     */
    public function putFollowupAction(Request $request, FollowUp $follow_up) {
        return $this->get('data_provider')
            ->createOrUpdate($request, $follow_up, FollowUpType::class);
    }
}
