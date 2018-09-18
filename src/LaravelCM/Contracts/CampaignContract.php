<?php

namespace Flobbos\LaravelCM\Contracts;
use Flobbos\LaravelCM\Contracts\BaseClientContract;

interface CampaignContract extends BaseClientContract{
    
    public function createDraft(array $options);
    
}