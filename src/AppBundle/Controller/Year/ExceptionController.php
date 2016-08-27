<?php

namespace AppBundle\Controller\Year;

use AppBundle\Entity\Year\Exception;
use AppBundle\Entity\Year\Period;
use AppBundle\Form\Year\ExceptionType;
use AppBundle\Form\Year\PeriodType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ExceptionController extends FOSRestController
{
    /**
     * Récupère le détail d'une exception.
     * @ApiDoc(
     *      resource = false,
     *      section = "Years",
     *      requirements = {
     *          { "name" = "exception", "dataType" = "uuid", "description" = "Example: a9dd6771-57f3-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("exception", class="AppBundle\Entity\Year\Exception")
     * @param Exception $exception
     * @return Exception
     */
    public function getExceptionAction(Exception $exception)
    {
        return $exception;
    }

    /**
     * Création d'une exception. Une exception est un jour ou une plage de jour qui surcharge les information d'une période.
     * @ApiDoc(
     *      resource = false,
     *      section = "Years"
     * )
     *
     * @param Request $request
     * @return Exception
     * @throw BadRequestHttpException
     */
    public function postExceptionAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Exception(), ExceptionType::class);
    }

    /**
     * Modification d'une période donnée.
     * @ApiDoc(
     *      resource = false,
     *      section = "Years",
     *      requirements = {
     *          { "name" = "exception", "dataType" = "uuid", "description" = "Example: a9dd6771-57f3-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Details"})
     * @ParamConverter("exception", class="AppBundle\Entity\Year\Exception")
     * @param Request $request
     * @param Exception $exception
     * @return Exception
     * @throw BadRequestHttpException
     */
    public function putExceptionsAction(Request $request, Exception $exception) {
        return $this->get('data_provider')
            ->createOrUpdate($request, $exception, ExceptionType::class);
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
     * @param Exception $exception
     * @return Exception
     */
    public function deleteExceptionAction(Exception $exception) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($exception);
        $em->flush();

        return $exception;
    }
}
