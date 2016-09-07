<?php

namespace AppBundle\Issuer;

use AppBundle\Entity\Promotion\Promotion;
use AppBundle\Provider\PresenceProvider;

class PresenceIssuer {
    protected $presenceProvider;

    public function __construct(PresenceProvider $presenceProvider)
    {
        $this->presenceProvider = $presenceProvider;
    }

    public function postStatistics(Promotion $promotion)
    {
        $statistics = $this->presenceProvider->getPromotionStatistics($promotion);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8001/update/statistics');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array_merge($statistics, ['id' => $promotion->getId()])));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
    }
}
