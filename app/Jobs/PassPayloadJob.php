<?php

namespace App\Jobs;

use GuzzleHttp\Client;

class PassPayloadJob extends Job
{
    private $endpoint;
    private $payload;

    public function __construct(string $endpoint, string $payload)
    {
        $this->endpoint = $endpoint;
        $this->payload = $payload;
    }

    public function handle(Client $client)
    {
        $response = $client->request('POST', $this->endpoint, [
                'body' => $this->payload
            ]);

            if ($response->getStatusCode() !== 200) {
                //Log error
            }

    }
}
