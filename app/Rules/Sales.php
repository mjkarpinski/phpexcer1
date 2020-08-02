<?php

namespace App\Rules;

final class Sales extends RuleAbstract
{
    public function passed(): bool
    {
        return $this->payload->getQueryType()->getId() === 'SALE MADE';
    }
}
