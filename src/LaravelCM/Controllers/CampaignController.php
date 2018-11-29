<?php

namespace Flobbos\LaravelCM\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flobbos\LaravelCM\Contracts\CampaignContract;
use Flobbos\LaravelCM\Contracts\ListContract;
use Flobbos\LaravelCM\Contracts\TemplateContract;
use Exception;

class CampaignController extends Controller{
    
    protected $cmp;
    
    public function __construct(CampaignContract $cmp) {
        $this->cmp = $cmp;
    }
    
    //Campaigns
    public function index(){
        try{
            $drafts = $this->cmp->getDrafts();
            $scheduled = $this->cmp->getScheduled();
            $sent = $this->cmp->getSent();
            return view('laravel-cm::campaigns.index')->with([
                'drafts' => $drafts,
                'scheduled' => $scheduled,
                'sent' => $sent
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    public function show($campaign_id){
        try{
            $summary = $this->cmp->getCampaignSummary($campaign_id);
            $users = $this->cmp->getEmailClientUsage($campaign_id);
            $lists = $this->cmp->getListsAndSegments($campaign_id);
            return view('laravel-cm::campaigns.show')->with([
                'campaign_id' => $campaign_id,
                'campaign' => $summary,
                'users' => $users,
                'lists' => $lists,
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    
    public function create(ListContract $lists, TemplateContract $templates){
        
        return view('laravel-cm::campaigns.create')->with([
            'lists' => $lists->get(),
            'templates' => $templates->getTemplatesFromDB()
        ]);
    }

    public function store(Request $request){
        //dd($request->all());
        $request->validate([
            'Name' => 'required',
            'Subject' => 'required',
            'FromName' => 'required',
            'FromEmail' => 'required|email',
            //'ReplyTo' => 'sometimes|email',
            'HtmlUrl' => 'url',
            'ListIDs' => 'required'
        ]);

        try{
            $campaign_id = $this->cmp->createDraft($request->except('_token'));
            return redirect()->route('laravel-cm::campaigns.index')->withMessage(trans('laravel-cm::campaigns.create_success',['campaign_id'=>$campaign_id]));
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage())->withInput();
        }

    }
    
    public function edit($campaign_id, ListContract $lists, TemplateContract $templates) {
        $drafts = $this->cmp->getDrafts();
        $campaign = $drafts->where('CampaignID', $campaign_id)->first();
        $listAndSegments = $this->cmp->getListsAndSegments($campaign->CampaignID);
        $campaign->ListIDs = $listAndSegments->Lists;

        return view('laravel-cm::campaigns.edit')->withCampaign($campaign)->withLists($lists->get())->withTemplates($templates->get());
    }

    public function update($campaign_id, Request $request) {
        $request->validate([
            'Name' => 'required',
            'Subject' => 'required',
            'FromName' => 'required',
            'FromEmail' => 'required|email',
            'ReplyTo' => 'sometimes|email',
            'HtmlUrl' => 'url',
            'ListIDs' => 'required'
        ]);

        try{
            $this->cmp->delete($campaign_id);
            $new_campaign_id = $this->cmp->createDraft($request->except(['_token']));

            return redirect()->route('laravel-cm::campaigns.index')->withMessage(trans('laravel-cm::campaigns.update_success',['new_campaign_id'=>$new_campaign_id]));
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }

    }

    public function showCampaignPreview($campaign_id){
        return view('laravel-cm::campaigns.send-test')->with([
            'campaign_id' => $campaign_id
        ]);
    }
    
    public function sendCampaignPreview(Request $request, $campaign_id){

        $request->validate([
            'emails' => 'required|emails'
        ]);

        $emails = explode(',', $request->get('emails'));

        $this->cmp->sendPreview($campaign_id, $emails);

        try{
            return redirect()->back()->withMessage(trans('laravel-cm::campaigns.test_send_success'));
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    public function scheduleCampaign($campaign_id){
        $campaign = $this->cmp->getCampaignDetails($campaign_id);
        //Check if campaign ID is valid.
        if(is_null($campaign)){
            return redirect()->back()->withErrors(trans('laravel-cm::campaigns.invalid_campaign_id'));
        }
        return view('laravel-cm::campaigns.schedule')->with([
            'campaign' => $campaign
        ]);
    }
    
    public function saveScheduleCampaign(Request $request, $campaign_id){
        try{
            $this->cmp->scheduleCampaign($campaign_id, $request->get('SendDate'), $request->get('ConfirmationEmail'));
            return redirect()->route('laravel-cm::campaigns.index')->withMessage(trans('laravel-cm::campaigns.schedule_success'));
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->withErrors($ex->getMessage());
        }
    }
    
    public function unScheduleCampaign($campaign_id){
        try{
            $this->cmp->unScheduleCampaign($campaign_id);
            return redirect()->route('laravel-cm::campaigns.index')->withMessage(trans('laravel-cm::campaigns.unschedule_success'));
        } catch (Exception $ex) {
            return redirect()->route('laravel-cm::campaigns.index')->withErrors($ex->getMessage());
        }
    }
    
    public function destroy($campaign_id){
        try{
            $this->cmp->delete($campaign_id);
            return redirect()->back()->withMessage(trans('laravel-cm::crud.delete_success'));
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    
}
