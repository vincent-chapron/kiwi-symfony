<?php

namespace AppBundle\Controller\Internship;

use AppBundle\Entity\Internship\Company;
use AppBundle\Entity\Internship\Internship;
use AppBundle\Form\Internship\CompanyType;
use AppBundle\Form\Internship\InternshipType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CompanyController extends FOSRestController
{
    /**
     * Récupération des détails d'un stage particulier.
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("company", class="AppBundle\Entity\Internship\Company")
     * @param Company $company
     * @return Company
     */
    public function getCompanyAction(Company $company)
    {
        return $company;
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships"
     * )
     *
     * @param Request $request
     * @return Company
     * @throw BadRequestHttpException
     */
    public function postCompanyAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Company(), CompanyType::class);
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Internships"
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("company", class="AppBundle\Entity\Internship\Company")
     * @param Request $request
     * @param Company $company
     * @return Company
     * @throw BadRequestHttpException
     */
    public function putCompanyAction(Request $request, Company $company) {
        return $this->get('data_provider')
            ->createOrUpdate($request, $company, CompanyType::class);
    }
}
