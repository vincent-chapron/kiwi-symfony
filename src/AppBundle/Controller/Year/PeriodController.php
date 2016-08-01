<?php

namespace AppBundle\Controller\Year;

use AppBundle\Entity\Year\Period;
use AppBundle\Form\Year\PeriodType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PeriodController extends FOSRestController
{
    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Years"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("year", class="AppBundle\Entity\Year\Period")
     * @param Period $period
     * @return Period
     */
    public function getPeriodAction(Period $period)
    {
        return $period;
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Years"
     * )
     *
     * @param Request $request
     * @return Period
     * @throw BadRequestHttpException
     */
    public function postPeriodsAction(Request $request)
    {
        $period = new Period();
        $form = $this->createForm(PeriodType::class, $period);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($period);
            $em->flush();

            return $period;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Years"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("promotion", class="AppBundle\Entity\Promotion\Promotion")
     * @param Request $request
     * @param Period $period
     * @return Period
     * @throw BadRequestHttpException
     */
    public function putPeriodsAction(Request $request, Period $period) {
        $form = $this->createForm(PeriodType::class, $period);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $period;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
    }
}
