<?php

namespace AppBundle\Provider;


use AppBundle\Entity\Course\Result;
use Doctrine\Common\Collections\ArrayCollection;

class StatisticProvider
{
    public function getStatistics(ArrayCollection $results) {
        $statistics = [
            "min"       => null,
            "max"       => null,
            "average"   => null
        ];

        foreach ($results as $result) {
            /** @var Result $result */
            $value = $result->getResult();

            if ($statistics["min"] === null)
                $statistics["min"] = $value;
            else if ($statistics["min"] > $value)
                $statistics["min"] = $value;

            if ($statistics["max"] === null)
                $statistics["max"] = $value;
            else if ($statistics["max"] < $value)
                $statistics["max"] = $value;

            if ($statistics["average"] === null)
                $statistics["average"] = $value;
            else
                $statistics["average"] += $value;
        }

        if ($statistics["average"] !== null) $statistics["average"] /= count($results);

        return $statistics;
    }
}
