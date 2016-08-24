<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Beacon;
use AppBundle\Entity\Promotion\Promotion;
use AppBundle\Form\BeaconType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BeaconController extends FOSRestController
{
    /**
     * Récupération des Beacons.
     * @ApiDoc(
     *      resource = false,
     *      section = "Beacons"
     * )
     *
     * @View(serializerGroups={"Default"})
     * @return ArrayCollection<Beacon>
     */
    public function getBeaconsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $beacon_repository = $em->getRepository('AppBundle:Beacon');
        $beacons = $beacon_repository->findAll();

        return $beacons;
    }

    /**
     * Ajout d'un Beacon.
     * @ApiDoc(
     *      resource = false,
     *      section = "Beacons",
     *      parameters = {
     *          { "name" = "secureUuid", "dataType" = "string", "required" = true, "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" },
     *          { "name" = "name", "dataType" = "string", "required" = true, "description" = "Example: Beacon pour la promotion 2019" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @param Request $request
     * @return Beacon
     */
    public function postBeaconsAction(Request $request)
    {
        $beacon = new Beacon();
        $form = $this->createForm(BeaconType::class, $beacon);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($beacon);
            $em->flush();

            return $beacon;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
    }

    /**
     * Suppression d'un Beacon.
     * @ApiDoc(
     *      resource = false,
     *      section = "Beacons",
     *      requirements = {
     *          { "name" = "beacon", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default"})
     * @ParamConverter("beacon", class="AppBundle\Entity\Beacon")
     * @param Beacon $beacon
     * @return Beacon
     */
    public function deleteBeaconAction(Beacon $beacon) {
        $em = $this->getDoctrine()->getManager();
        foreach ($beacon->getPromotions() as $promotion) {
            /** @var Promotion $promotion */
            $promotion->removeBeacon($beacon);
        }
        $em->remove($beacon);
        $em->flush();

        return $beacon;
    }
}
