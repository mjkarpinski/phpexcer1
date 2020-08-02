<?php

namespace App\Identifier;

final class Payload
{
    public const JSON_TYPE = 'json';

    public static function identifyType(string $payload)
    {
        if (is_object(json_decode($payload)) || is_array(json_decode($payload))) {
            return self::JSON_TYPE;
        }
    }
}
