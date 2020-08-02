<?php

namespace App\Rules;

use App\DTO\Payload;

abstract class RuleAbstract implements RuleInterface
{
    protected $payload;

    public function __construct(Payload $payload)
    {
        $this->payload = $payload;
    }
}
