<?php

namespace Flobbos\LaravelCM\Contracts;
use Flobbos\LaravelCM\Contracts\BaseClientContract;

interface CampaignContract extends BaseClientContract{
    
    public function getDrafts();
    
    public function getSent();
    
    public function getScheduled();
    
    public function getCampaignDetails(string $campaign_id, string $type = 'drafts');
    
    public function getCampaignSummary($campaign_id);
    
    public function getEmailClientUsage($campaign_id);
    
    public function getListsAndSegments(string $campaign_id);
    
    public function sendPreview(string $campaign_id, array $recipients = []);
    
    public function scheduleCampaign(string $campaign_id, string $date_time, string $confirmation_emails);
    
    public function unScheduleCampaign(string $campaign_id);
    
    public function createDraft(array $options);
    
    public function delete(string $campaign_id);
    
}