<?php

namespace AppBundle\Controller\Year;

use AppBundle\Entity\Year\Period;
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
     * Récupération de toutes les années.
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
     * Récupération d'une année.
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
     * Récupère toutes les périodes d'une année.
     * Récupération d'une année.
     * @ApiDoc(
     *      resource = false,
     *      section = "Years"
     * )
     *
     * @View(serializerGroups={"Default"})
     * @param $year
     * @return ArrayCollection<Period>
     */
    public function getYearPeriodsAction($year)
    {
        $em = $this->getDoctrine()->getManager();
        $period_repository = $em->getRepository('AppBundle:Year\Period');
        $periods = $period_repository->findByYear($year);

        return $periods;
    }

    /**
     * Création d'une année. Une année est une donnée qui va permettre de situer dans le temps toutes les données créer relier à celle ci.
     * On va pouvoir ainsi avec un historique complet et sans perte d'information.
     * Le 10 janvier 2016, cet étudiant était dans cette promotion et à eu cette note, avait ce stage ...
     * @ApiDoc(
     *      resource = false,
     *      section = "Years"
     * )
     *
     * name
     * startAt
     * endAt
     * promotion
     *
     * @param Request $request
     * @return Year
     */
    public function postYearsAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Year(), YearType::class);
    }

    /**
     * Modification des informations d'une année.
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
        return $this->get('data_provider')
            ->createOrUpdate($request, $year, YearType::class);
    }
}
