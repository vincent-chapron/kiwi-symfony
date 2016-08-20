<?php

namespace AppBundle\Controller\Promotion;

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
        $em = $this->getDoctrine()->getManager();
        $students = $promotion->getStudents();
        $statistics = ["total" => count($students)];

        $presence_repository = $em->getRepository('AppBundle:Presence\Historic');
        $period = $promotion->getCurrentPeriod();
        $exception = $promotion->getCurrentException();
        $data = $exception ? $exception : $period;

        if (!$data) return array_merge($statistics, ['out-of-range' => count($students)]);

        foreach ($students as $student) {
            /**
             * @var Student $student
             * @var Historic $presence
             */
            $presence = $presence_repository->getCurrentPresence($student);
            $status = $presence->getStatus() ? strtolower($presence->getStatus()) : 'waiting';

            if (array_key_exists($status, $statistics)) {
                $statistics[$status] += 1;
            } else {
                $statistics[$status] = 1;
            }
        }

        return $statistics;
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
     * @View(serializerGroups={"Default"})
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
     * Création d'une promotion. Une promotion est un groupe d'élèves.
     * @ApiDoc(
     *      resource = false,
     *      section = "Promotions",
     *      parameters = {
     *          { "name" = "name", "dataType" = "string", "required" = true, "description" = "Example: Promotion 2019" }
     *      }
     * )
     *
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
