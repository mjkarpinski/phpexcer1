<?php

namespace App\Http\Controllers;

use App\DTO\Payload;
use App\Identifier\Payload as PayloadIdentifier;
use App\Jobs\PassPayloadJob;
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

            if ($passed) {
                dispatch(new PassPayloadJob($microservice['endpoint'], $payload));
            }
        }

        if (!$status) {
            return response('Data has not been processed');
        }

        return response('All data processed successfully');
    }

}
