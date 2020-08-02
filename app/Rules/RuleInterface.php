<?php

namespace App\Rules;

use App\DTO\Payload;

interface RuleInterface
{
    public function __construct(Payload $payload);
    public function passed(): bool;
}
