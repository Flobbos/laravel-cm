<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Guzzler\ImportInterface;
use App\Guzzler\SubscriberInterface;
use App\Guzzler\ListInterface;
use App\Guzzler\CampaignContract;
use Exception;

class NewsletterController extends Controller{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
            Request $request, 
            SubscriberInterface $subscribers,
            ListInterface $listings){
        try{
            /*$g = $subscribers->getGuzzle();
            //dd($subscribers->getAuthInformation());
            dd($g->post('https://api.createsend.com/api/v3.2/campaigns/'.$subscribers->getClientID().'.json',[
                'json' => [
                    'Name' => 'TestCampaign',
                    'Subject' => 'TestSubject',
                    'FromName' => 'Big Kahoona',
                    'FromEmail' => 'big@kahoona.com',
                    'ReplyTo' => 'nl@kahoona.com',
                    'HtmlUrl' => url('newsletter-test'),
                    'ListIDs' => [
                        $subscribers->getListID()
                    ],
                'auth' => $subscribers->getAuthInformation(),
                'stream' => true,
                'headers' => [
                        'Accept' => 'application/json'
                    ]
                ]
            ]));*/
            
            if($request->has('listID')){
                $subscribers->setListID($request->get('listID'));
                $listings->setListID($request->get('listID'));
            }
            $lists = $listings->get();
            $subscribed = $subscribers->getActive(true, $request->get('subscribers'));
            $unconfirmed = $subscribers->getUnconfirmed(true, $request->get('unconfirmed'));
            $unsubscribed = $subscribers->getUnsubscribed(true,$request->get('unsubscribed'));
        } catch (Exception $ex) {
            return view('admin.newsletters.index')->with([
                'subscribed' => collect([]),
                'unconfirmed' => collect([]),
                'unsubscribed' => collect([]),
                'lists' => collect([]),
            ])->withErrors($ex->getMessage().' -- '.$ex->getFile());
        }
        return view('admin.newsletters.index')->with([
            'subscribed' => $subscribed,
            'unconfirmed' => $unconfirmed,
            'unsubscribed' => $unsubscribed,
            'lists' => $lists
        ]);
    }
    
    public function showImportExcel(){
        return view('admin.newsletters.import');
    }
    
    public function importExcel(Request $request){
        //dd($request->all());
        if(!$request->hasFile('excel')){
            return redirect()->back()->withErrors('Keine Excel Datei gefunden.');
        }
        //Handle file upload
        try{
            $result = $this->api->importSubscribers($request);
            return redirect()->back()->with([
                'result' => $result
            ])->withMessage('Import erfolgreich');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.newsletters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [
            'Title' => 'required',
        ]);
        try{
            $result = $this->api->createList($request->except('_token'));
            return redirect()->route('admin.newsletters.index')->withMessage(trans('crud.record_created').' ID: '.$result->get('body'));
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($email){
        $subscriber = $this->api->getSubscriberDetails($email);
        //dd($subscriber);
        return view('admin.newsletters.show')->with([
            'subscriber'=>$subscriber->get('body')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        return view('admin.newsletters.edit')->with(['newsletter'=>$this->newsletters->find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $email){
        try{
            if(!$this->api->resubscribeSubscriber($email)){
                throw new Exception('E-Mail-Adresse konnte nicht erneut angemeldet werden.');
            }
            return redirect()->route('admin.newsletters.index')->withMessage('Anmeldung erfolgreich');
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($email){
        try{
            $this->api->removeSubscriber($email);
            return redirect()->route('admin.newsletters.index')->withMessage(trans('crud.record_deleted'));
        } catch (Exception $ex) {
            return redirect()->route('admin.newsletters.index')->withErrors($ex->getMessage());
        }
    }
    
    //Templates
    public function showCreateTemplate(){
        return view('admin.newsletters.create-template');
    }
    
    public function storeTemplate(Request $request, CampaignContract $campaigns){
        //dd($request->all());
        $campaigns->createDraft($request->except('_token'));
        return redirect()->back()->withMessage('Campaign angelegt');
    }
}

