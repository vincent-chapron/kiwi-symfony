<?php

namespace AppBundle\Controller\Promotion;

use AppBundle\Entity\Beacon;
use AppBundle\Entity\Presence\Historic;
use AppBundle\Entity\Promotion\Promotion;
use AppBundle\Entity\Student;
use AppBundle\Form\Promotion\PromotionType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PromotionController extends FOSRestController
{
    /**
     * Récupération de toutes les promotions.
     * @ApiDoc(
     *      resource = false,
     *      section = "Promotions"
     * )
     *
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
     * Récupération des détails d'une promotion particulière.
     * @ApiDoc(
     *      resource = false,
     *      section = "Promotions",
     *      requirements = {
     *          { "name" = "promotion", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Promotion"})
     * @ParamConverter("promotion", class="AppBundle\Entity\Promotion\Promotion")
     * @param Promotion $promotion
     * @return Promotion
     */
    public function getPromotionAction(Promotion $promotion)
    {
        return $promotion;
    }

    /**
     * @ApiDoc(
     *      resource = false,
     *      section = "Promotions"
     * )
     *
     * @View(serializerGroups={"Default"})
     * @ParamConverter("promotion", class="AppBundle\Entity\Promotion\Promotion")
     * @param Promotion $promotion
     * @return array
     */
    public function getPromotionStatisticsAction(Promotion $promotion) {
        return $this->get('presence_provider')->getPromotionStatistics($promotion);
    }

    /**
     * Récupération des étudiants d'une promotion particulière.
     * @ApiDoc(
     *      resource = false,
     *      section = "Promotions",
     *      requirements = {
     *          { "name" = "promotion", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Promotion"})
     * @param $promotion
     * @return ArrayCollection<Student>
     */
    public function getPromotionStudentsAction($promotion)
    {
        $em = $this->getDoctrine()->getManager();
        $student_repository = $em->getRepository('AppBundle:Student');
        $students = $student_repository->findByPromotion($promotion);

        return $students;
    }

    /**
     * Récupération des cours d'une promotion particulière.
     * @ApiDoc(
     *      resource = false,
     *      section = "Promotions",
     *      requirements = {
     *          { "name" = "promotion", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Promotion"})
     * @param $promotion
     * @return ArrayCollection<Course>
     */
    public function getPromotionCoursesAction($promotion)
    {
        $em = $this->getDoctrine()->getManager();
        $course_repository = $em->getRepository('AppBundle:Course\Course');
        $courses = $course_repository->findByPromotion($promotion);

        return $courses;
    }

    /**
     * Création d'une promotion. Une promotion est un groupe d'élèves.
     * @ApiDoc(
     *      resource = false,
     *      section = "Promotions",
     *      parameters = {
     *          { "name" = "name", "dataType" = "string", "required" = true, "description" = "Example: Promotion 2019" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Promotion"})
     * @param Request $request
     * @return Promotion
     */
    public function postPromotionsAction(Request $request)
    {
        return $this->get('data_provider')
            ->createOrUpdate($request, new Promotion(), PromotionType::class);
    }

    /**
     * Modification d'une promotion.
     * @ApiDoc(
     *      resource = false,
     *      section = "Promotions",
     *      requirements = {
     *          { "name" = "promotion", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" }
     *      },
     *      parameters = {
     *          { "name" = "name", "dataType" = "string", "required" = true, "description" = "Example: Promotion 2020" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Promotion"})
     * @ParamConverter("promotion", class="AppBundle\Entity\Promotion\Promotion")
     * @param Request $request
     * @param Promotion $promotion
     * @return Promotion
     * @throw BadRequestHttpException
     */
    public function putPromotionsAction(Request $request, Promotion $promotion) {
        return $this->get('data_provider')
            ->createOrUpdate($request, $promotion, PromotionType::class);
    }

    /**
     * Modification d'une promotion.
     * @ApiDoc(
     *      resource = false,
     *      section = "Promotions",
     *      requirements = {
     *          { "name" = "promotion", "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef07" },
     *          { "name" = "beacon",    "dataType" = "uuid", "description" = "Example: 1d413e5d-57da-11e6-ae94-0071bec7ef08" }
     *      }
     * )
     *
     * @View(serializerGroups={"Default", "Promotion"})
     * @ParamConverter("promotion", class="AppBundle\Entity\Promotion\Promotion")
     * @ParamConverter("beacon", class="AppBundle\Entity\beacon")
     * @param Promotion $promotion
     * @param Beacon $beacon
     * @return Promotion
     * @throw BadRequestHttpException
     */
    public function patchPromotionBeaconAction(Promotion $promotion, Beacon $beacon) {
        $em = $this->getDoctrine()->getManager();
        $promotion->addBeacon($beacon);
        $em->flush();

        return $promotion;
    }
}
