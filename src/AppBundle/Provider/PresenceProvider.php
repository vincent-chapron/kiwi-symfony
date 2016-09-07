<?php

namespace AppBundle\Provider;

use AppBundle\Entity\Presence\Historic;
use AppBundle\Entity\Promotion\Promotion;
use AppBundle\Entity\Student;
use Doctrine\ORM\EntityManager;

class PresenceProvider
{
    protected $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function getPromotionStatistics(Promotion $promotion) {
        $students = $promotion->getStudents();
        $statistics = ["total" => count($students)];

        $presence_repository = $this->manager->getRepository('AppBundle:Presence\Historic');
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

            if (!$presence)
                $status = 'waiting';
            else
                $status = $presence->getStatus() ? strtolower($presence->getStatus()) : 'waiting';

            if (array_key_exists($status, $statistics)) {
                $statistics[$status] += 1;
            } else {
                $statistics[$status] = 1;
            }
        }

        return $statistics;
    }
}
