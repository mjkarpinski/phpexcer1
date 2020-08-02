<?php

namespace App\PayloadDecoder;

use App\DTO\CallStats;
use App\DTO\Campaign;
use App\DTO\Payload;
use App\DTO\QueryType;

use Exception;

final class JsonPayloadDecoder implements PayloadDecoderInterface
{
    public function decode(string $payload)
    {
        $payloadEntry = json_decode($payload);

        if (!$this->validateEntry($payloadEntry)) {
            //Log message about broken data
            throw new Exception();
        }

        $queryType = new QueryType($payloadEntry['query_type']['id'], $payloadEntry['query_type']['title']);
        $callStats = new CallStats(
            $payloadEntry['call_stats']['id'],
            $payloadEntry['call_stats']['length'],
            $payloadEntry['call_stats']['recording_url']
        );

        $campaign = new Campaign(
            $payloadEntry['campaign']['id'],
            $payloadEntry['campaign']['name'],
            $payloadEntry['campaign']['description']
        );

        $payloadEntries[] = new Payload(
            $payloadEntry['name'],
            $payloadEntry['phone'],
            $payloadEntry['email'],
            $queryType,
            $callStats,
            $campaign
        );


        return $payloadEntries;
    }

    private function validateEntry(array $payloadEntry): bool
    {
        if (!isset($payloadEntry['query_type']['id'])) {
            return false;
        }

        if (!isset($payloadEntry['query_type']['title'])) {
            return false;
        }

        if (!isset($payloadEntry['call_stats']['id'])) {
            return false;
        }

        if (!isset($payloadEntry['call_stats']['length'])) {
            return false;
        }

        if (!isset($payloadEntry['call_stats']['recording_url'])) {
            return false;
        }

        if (!isset($payloadEntry['campaign']['id'])) {
            return false;
        }

        if (!isset($payloadEntry['campaign']['name'])) {
            return false;
        }

        if (!isset($payloadEntry['campaign']['description'])) {
            return false;
        }

        if (!isset($payloadEntry['name'])) {
            return false;
        }

        if (!isset($payloadEntry['phone'])) {
            return false;
        }

        if (!isset($payloadEntry['email'])) {
            return false;
        }

        return true;
    }
}
