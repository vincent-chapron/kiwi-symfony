<?php

namespace AppBundle\Controller\Year;

use AppBundle\Entity\Year\Year;
use AppBundle\Form\Year\YearType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class YearController extends FOSRestController
{
    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Years"
     * )
     *
     * @View(serializerGroups={"Default"})
     * @return ArrayCollection<Year>
     */
    public function getYearsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $year_repository = $em->getRepository('AppBundle:Year\Year');
        $years = $year_repository->findAll();

        return $years;
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Years"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("year", class="AppBundle\Entity\Year\Year")
     * @param Year $year
     * @return Year
     */
    public function getYearAction(Year $year)
    {
        return $year;
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Years"
     * )
     *
     * @param Request $request
     * @return Year
     */
    public function postYearsAction(Request $request)
    {
        $year = new Year();
        $form = $this->createForm(YearType::class, $year);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($year);
            $em->flush();

            return $year;
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
     * @param Year $year
     * @return Year
     * @throw BadRequestHttpException
     */
    public function putYearsAction(Request $request, Year $year) {
        $form = $this->createForm(YearType::class, $year);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $year;
        }

        throw new BadRequestHttpException($this->get('translator')->trans('exception.bad_request._default'));
    }
}
