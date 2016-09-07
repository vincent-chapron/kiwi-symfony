<?php

namespace AppBundle\Issuer;

use AppBundle\Entity\Promotion\Promotion;
use AppBundle\Provider\PresenceProvider;
use Circle\RestClientBundle\Services\RestClient;

class PresenceIssuer {
    protected $presenceProvider;
    protected $restClient;

    public function __construct(PresenceProvider $presenceProvider, RestClient $restClient)
    {
        $this->presenceProvider = $presenceProvider;
        $this->restClient = $restClient;
    }

    public function postStatistics(Promotion $promotion)
    {
        $statistics = $this->presenceProvider->getPromotionStatistics($promotion);

        $this->restClient->post(
            "http://127.0.0.1:8001/update/statistics",
            json_encode(array_merge($statistics, ['id' => $promotion->getId()])),
            [CURLOPT_HTTPHEADER, ['Content-type: application/json']]
        );
    }
}
