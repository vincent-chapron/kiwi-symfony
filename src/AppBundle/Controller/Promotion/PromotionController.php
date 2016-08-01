<?php

namespace AppBundle\Controller\Promotion;

use AppBundle\Entity\Promotion\Promotion;
use AppBundle\Form\Promotion\PromotionType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PromotionController extends FOSRestController
{
    /**
     * @View(serializerGroups={"Default"})
     * @return ArrayCollection<Promotion>
     */
    public function getPromotionsAction() {
        $em = $this->getDoctrine()->getManager();
        $promotion_repository = $em->getRepository('AppBundle:Promotion\Promotion');
        $promotions = $promotion_repository->findAll();

        return $promotions;
    }

    /**
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("promotion", class="AppBundle\Entity\Promotion\Promotion")
     * @param Promotion $promotion
     * @return Promotion
     */
    public function getPromotionAction(Promotion $promotion)
    {
        return $promotion;
    }

    /**
     * @param Request $request
     * @return Promotion
     */
    public function postPromotionsAction(Request $request)
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();

            return $promotion;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
    }

    /**
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("promotion", class="AppBundle\Entity\Promotion\Promotion")
     * @param Request $request
     * @param Promotion $promotion
     * @return Promotion
     * @throw BadRequestHttpException
     */
    public function putPromotionsAction(Request $request, Promotion $promotion) {
        $form = $this->createForm(PromotionType::class, $promotion);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $promotion;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
    }
}
