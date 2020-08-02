<?php

namespace App\DTO;

final class Payload
{
    private $name;
    private $phone;
    private $queryType;
    private $callStats;
    private $campaign;

    public function __construct(
        string $name,
        string $phone,
        QueryType $queryType,
        CallStats $callStats,
        Campaign $campaign
    ) {
        $this->name = $name;
        $this->phone = $phone;
        $this->queryType = $queryType;
        $this->callStats = $callStats;
        $this->campaign = $campaign;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getQueryType(): QueryType
    {
        return $this->queryType;
    }

    public function getCallStats(): CallStats
    {
        return $this->callStats;
    }

    public function getCampaign(): Campaign
    {
        return $this->campaign;
    }

}
