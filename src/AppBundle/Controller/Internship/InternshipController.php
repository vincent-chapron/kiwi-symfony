<?php

namespace AppBundle\Controller\Internship;

use AppBundle\Entity\Internship\Internship;
use AppBundle\Form\Internship\InternshipType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class InternshipController extends FOSRestController
{
    /**
     * Récupération des détails d'un stage particulier.
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships",
     *      requirements = {
     *          { "name" = "internship", "dataType" = "uuid", "description" = "Example: a9dd6771-57f3-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Internship"})
     * @ParamConverter("internship", class="AppBundle\Entity\Internship\Internship")
     * @param Internship $internship
     * @return Internship
     */
    public function getInternshipAction(Internship $internship)
    {
        return $internship;
    }

    /**
     * Création d'un stage. Un stage est à la fois rataché à un étudiant, et à une année.
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships",
     *      parameters = {
     *          { "name" = "startAt", "dataType" = "date", "format" = "yyyy-MM-dd", "required" = true, "description" = "Example: 2016-06-01" },
     *          { "name" = "endAt",   "dataType" = "date", "format" = "yyyy-MM-dd", "required" = true, "description" = "Example: 2016-12-10" },
     *          { "name" = "year",    "dataType" = "uuid",                          "required" = true, "description" = "Example: 8e194bc0-57ec-11e6-ae94-0071bec7ef07" },
     *          { "name" = "student", "dataType" = "uuid",                          "required" = true, "description" = "Example: c5970aa4-537e-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @param Request $request
     * @return Internship
     * @throw BadRequestHttpException
     */
    public function postInternshipsAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Internship(), InternshipType::class);
    }

    /**
     * Modification d'un stage. Pour compléter ou corriger les informations d'un stage déjà créé.
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships",
     *      requirements = {
     *          { "name" = "internship", "dataType" = "uuid", "description" = "Example: a9dd6771-57f3-11e6-ae94-0071bec7ef07" }
     *      },
     *      parameters = {
     *          { "name" = "startAt", "dataType" = "date", "format" = "yyyy-MM-dd", "required" = false, "description" = "Example: 2016-06-01" },
     *          { "name" = "endAt",   "dataType" = "date", "format" = "yyyy-MM-dd", "required" = false, "description" = "Example: 2016-12-10" },
     *          { "name" = "year",    "dataType" = "uuid",                          "required" = false, "description" = "Example: 8e194bc0-57ec-11e6-ae94-0071bec7ef07" },
     *          { "name" = "student", "dataType" = "uuid",                          "required" = false, "description" = "Example: c5970aa4-537e-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("internship", class="AppBundle\Entity\Internship\Internship")
     * @param Request $request
     * @param Internship $internship
     * @return Internship
     * @throw BadRequestHttpException
     */
    public function putInternshipsAction(Request $request, Internship $internship) {
        return $this->get('data_provider')
            ->createOrUpdate($request, $internship, InternshipType::class);
    }
}
