<?php

namespace Flobbos\LaravelCM\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flobbos\LaravelCM\Contracts\SubscriberContract;
use Flobbos\LaravelCM\Contracts\ListContract;
use Exception;

class SubscriberController extends Controller{
    
    protected $subscribers;
    
    public function __construct(SubscriberContract $subscribers) {
        $this->subscribers = $subscribers;
    }
    
    public function index(Request $request, ListContract $lists){
        try{
            if($request->has('listID')){
                $this->subscribers->setListID($request->get('listID'));
                $listings->setListID($request->get('listID'));
            }
            $email_lists = $lists->get();
            $subscribed = $this->subscribers->getActive($request->get('subscribers')?:1,'subscribers');
            $unconfirmed = $this->subscribers->getUnconfirmed($request->get('unconfirmed')?:1,'unconfirmed');
            $unsubscribed = $this->subscribers->getUnsubscribed($request->get('unsubscribed')?:1,'unsubscribed');
            $bounced = $this->subscribers->getBounced($request->get('bounced')?:1, 'bounced');
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
            'lists' => $email_lists
        ]);
    }
    
    public function show($email, SubscriberInterface $subscribers){
        $subscriber = $subscribers->getDetails($email);
        //dd($subscriber);
        return view('admin.newsletters.show')->with([
            'subscriber'=>$subscriber->get('body')
        ]);
    }
    
    
}