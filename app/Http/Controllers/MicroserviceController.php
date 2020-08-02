<?php

namespace App\Http\Controllers;

use App\DTO\Payload;
use App\Identifier\Payload as PayloadIdentifier;
use App\PayloadDecoder\JsonPayloadDecoder;
use App\Rules\DisallowCampaignB;
use App\Rules\RuleInterface;
use App\Rules\Sales;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

use Exception;

final class MicroserviceController extends BaseController
{
    public function index(Request $request) {

        $status = true;
        $requestContent = $request->getContent();
        $payload = $requestContent['body'];
        $payloadType = PayloadIdentifier::identifyType($payload);

        if ($payloadType === PayloadIdentifier::JSON_TYPE) {
            try {
                $payloadDto = (new JsonPayloadDecoder())->decode($payload);
            } catch (Exception $exception) {
                //Handle this
            }
        }

        if (!isset($payloadDto) || (gettype($payloadDto) !== Payload::class)){
            //Should be handled better
            return false;
        }

        //Get Available rules from DB, hack it for now:

        $microservices = [
            'A' => [
                'url' => 'www.a.endpoint.com',
                'rules' => [
                    DisallowCampaignB::class
                ]
            ],
            'B' => [
                'url' => 'www.b.endpoint.com',
                'rules' => [
                    Sales::class
                ],
            ],
            'C' => [
                'url' => 'www.b.endpoint.com',
                'rules' => [],
            ]
        ];

        foreach ($microservices as $microservice) {
            $passed = true;

            foreach ($microservice['rules'] as $rule) {
                if (!$passed) {
                    continue;
                }

                /** @var RuleInterface $ruleObject */
                $ruleObject = new $rule($payload);

                if (!$ruleObject->passed()) {
                    $passed = false;
                }
            }

            // Guzzle request to
            // Add to queue rather than running requests in foreach

            //Commented out since, we don't have actual endpoints
//            $client = new Client();
//
//            $response = $client->request('POST', $microservice, [
//                'body' => $payload
//            ]);
//
//            if ($response->getStatusCode() !== 200) {
//                $status = false;
//            }
        }

        if (!$status) {
            return response('Data has not been processed');
        }

        return response('All data processed successfully');
    }

}
