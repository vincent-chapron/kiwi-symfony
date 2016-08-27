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
     * Récupère le détail d'un période.
     * @ApiDoc(
     *      resource = false,
     *      section = "Years",
     *      requirements = {
     *          { "name" = "period", "dataType" = "uuid", "description" = "Example: a9dd6771-57f3-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("period", class="AppBundle\Entity\Year\Period")
     * @param Period $period
     * @return Period
     */
    public function getPeriodAction(Period $period)
    {
        return $period;
    }

    /**
     * Création d'une période. Une période est par exemple un trimestre ou un semestre. Elle servira à regrouper les notes et autres informations d'un étudiant.
     * @ApiDoc(
     *      resource = false,
     *      section = "Years",
     *      parameters = {
     *          { "name" = "name",    "dataType" = "string",                          "required" = true, "description" = "Example: Semestre 1" },
     *          { "name" = "startAt", "dataType" = "date",   "format" = "yyyy-MM-dd", "required" = true, "description" = "Example: 2015-09-01" },
     *          { "name" = "endAt",   "dataType" = "date",   "format" = "yyyy-MM-dd", "required" = true, "description" = "Example: 2015-01-01" },
     *          { "name" = "year",    "dataType" = "uuid",                            "required" = true, "description" = "Example: 8e194bc0-57ec-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @param Request $request
     * @return Period
     * @throw BadRequestHttpException
     */
    public function postPeriodsAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Period(), PeriodType::class);
    }

    /**
     * Modification d'une période donnée.
     * @ApiDoc(
     *      resource = false,
     *      section = "Years",
     *      requirements = {
     *          { "name" = "period", "dataType" = "uuid", "description" = "Example: a9dd6771-57f3-11e6-ae94-0071bec7ef07" }
     *      },
     *      parameters = {
     *          { "name" = "name",    "dataType" = "string",                          "required" = false, "description" = "Example: Semestre 2" },
     *          { "name" = "startAt", "dataType" = "date",   "format" = "yyyy-MM-dd", "required" = false, "description" = "Example: 2016-01-01" },
     *          { "name" = "endAt",   "dataType" = "date",   "format" = "yyyy-MM-dd", "required" = false, "description" = "Example: 2016-07-01" }
     *      }
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
        return $this->get('data_provider')
            ->createOrUpdate($request, $period, PeriodType::class);
    }

    /**
     * Suppression d'une Exception.
     * @ApiDoc(
     *      resource = false,
     *      section = "Years",
     *      requirements = {
     *          { "name" = "exception", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default"})
     * @ParamConverter("beacon", class="AppBundle\Entity\Year\Exception")
     * @param Period $period
     * @return Period
     */
    public function deletePeriodAction(Period $period) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($period);
        $em->flush();

        return $period;
    }
}
