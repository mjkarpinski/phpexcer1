<?php

namespace App\PayloadDecoder;

interface PayloadDecoderInterface
{
    public function decode(string $payload);
}
