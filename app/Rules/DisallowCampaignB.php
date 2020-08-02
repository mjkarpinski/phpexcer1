<?php

namespace App\Rules;

final class DisallowCampaignB extends RuleAbstract
{
    public function passed(): bool
    {
        return $this->payload->getCampaign()->getDescription() !== 'Campaign B';
    }
}
