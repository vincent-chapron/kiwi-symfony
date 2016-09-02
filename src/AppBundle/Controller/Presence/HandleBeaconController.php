<?php

namespace AppBundle\Controller\Presence;

use AppBundle\Entity\Beacon;
use AppBundle\Entity\Presence\Historic;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class HandleBeaconController extends FOSRestController
{
    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Presence"
     * )
     *
     * @View(serializerGroups={"Default"})
     * @Post("/authorized/to/arrived", name="post_arrived", options={"method_prefix" = false});
     * @param Request $request
     * @return array
     */
    public function postArrivedAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        /** @var User $user */
        if (!$user) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.presence_not_found'));
        }

        $student = $user->getStudent();

        if (!$student) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.presence_not_found'));
        }

        /** @var Historic $presence */
        $presence_repository = $em->getRepository('AppBundle:Presence\Historic');
        $presence = $presence_repository->getCurrentPresence($student);

        if (!$presence) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.presence_not_found'));
        }

//        $data = json_decode($request->getContent(), true);
//        $secure_uuid = array_key_exists('secureUuid', $data) ? $data["secureUuid"] : null;

//        if (!$secure_uuid) {
//            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.parameter_is_missing'));
//        }

//        $beacon_repository = $em->getRepository('AppBundle:Beacon');
//        $beacon = $beacon_repository->findOneBySecureUuid($secure_uuid);

//        if (!$student->getPromotion()->getBeacons()->contains($beacon)) {
//            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.wrong_beacon'));
//        }

        if ($presence->isArrived()) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.already_arrived'));
        }

        $period = $student->getPromotion()->getCurrentPeriod();
        $exception = $student->getPromotion()->getCurrentException();
        $data = $exception ? ($exception->getPresenceRequired() ? $exception : $period) : $period;

        if (!$data) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.presence_not_required'));
        }

        $startTime = date('H:i', strtotime($data->getStartArrivedTime()));
        $endTime = date('H:i', strtotime($data->getEndArrivedTime()));
        $time = date('H:i');

        if ($time < $startTime || $time > $endTime) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.not_time_to_arrived'));
        }

        $presence->setArrived(true);
        $presence->setStatus("present");
        $em->flush();

        return [
            "success" => true,
            "data" => $presence
        ];
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Presence"
     * )
     *
     * @View(serializerGroups={"Default"})
     * @Post("/authorized/to/left", name="post_left", options={"method_prefix" = false});
     * @param Request $request
     * @return array
     */
    public function postLeftAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        /** @var User $user */
        if (!$user) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.presence_not_found'));
        }

        $student = $user->getStudent();

        if (!$student) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.presence_not_found'));
        }

        /** @var Historic $presence */
        $presence_repository = $em->getRepository('AppBundle:Presence\Historic');
        $presence = $presence_repository->getCurrentPresence($student);

        if (!$presence) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.presence_not_found'));
        }

//        $data = json_decode($request->getContent(), true);
//        $secure_uuid = array_key_exists('secureUuid', $data) ? $data["secureUuid"] : null;

//        if (!$secure_uuid) {
//            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.parameter_is_missing'));
//        }

//        $beacon_repository = $em->getRepository('AppBundle:Beacon');
//        $beacon = $beacon_repository->findOneBySecureUuid($secure_uuid);

//        if (!$student->getPromotion()->getBeacons()->contains($beacon)) {
//            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.wrong_beacon'));
//        }

        if ($presence->isLeft()) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.already_left'));
        }

        $period = $student->getPromotion()->getCurrentPeriod();
        $exception = $student->getPromotion()->getCurrentException();
        $data = $exception ? ($exception->getPresenceRequired() ? $exception : $period) : $period;

        if (!$data) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.presence_not_required'));
        }

        $startTime = date('H:i', strtotime($data->getStartLeftTime()));
        $endTime = date('H:i', strtotime($data->getEndLeftTime()));
        $time = date('H:i');

        if ($time < $startTime || $time > $endTime) {
            throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request.not_time_to_left'));
        }

        $presence->setLeft(true);
        $em->flush();

        return [
            "success" => true,
            "data" => $presence
        ];
    }
}
