<?php

namespace Flobbos\LaravelCM;

use Flobbos\LaravelCM\BaseClient;
use Flobbos\LaravelCM\Contracts\SubscriberContract;
use Flobbos\LaravelCM\Contracts\ResultFormatContract;
use Illuminate\Http\Request;
use Exception;

class Subscribers extends BaseClient implements SubscriberContract, ResultFormatContract
{

    use \Flobbos\LaravelCM\Traits\ResultFormat;
    use \Flobbos\LaravelCM\Traits\BaseImport;

    //Getters
    public function getActive(int $page = 1, $pageName = 'page', int $perPage = 25)
    {
        $result = $this->makeCall('lists/' . $this->getListID() . '/active', [
            'query' => [
                'page' => $page,
                'pagesize' => $perPage,
            ],
        ]);
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        //Return formatted list
        return $this->formatSubscribers($result->get('body'), $pageName);
    }

    public function getUnsubscribed(int $page = 1, $pageName = 'page', int $perPage = 25)
    {
        $result = $this->makeCall('lists/' . $this->getListID() . '/unsubscribed', [
            'query' => [
                'page' => $page,
                'pagesize' => $perPage,
            ],
        ]);
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        return $this->formatSubscribers($result->get('body'));
    }

    public function getUnconfirmed(int $page = 1, $pageName = 'page', int $perPage = 25)
    {
        $result = $this->makeCall('lists/' . $this->getListID() . '/unconfirmed', [
            'query' => [
                'page' => $page,
                'pagesize' => $perPage,
            ],
        ]);
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        return $this->formatSubscribers($result->get('body'));
    }

    public function getDeleted(int $page = 1, $pageName = 'page', int $perPage = 25)
    {
        $result = $this->makeCall('lists/' . $this->getListID() . '/deleted', [
            'query' => [
                'page' => $page,
                'pagesize' => $perPage,
            ],
        ]);
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        return $this->formatSubscribers($result->get('body'));
    }

    public function getBounced(int $page = 1, $pageName = 'page', int $perPage = 25)
    {
        $result = $this->makeCall('lists/' . $this->getListID() . '/bounced', [
            'query' => [
                'page' => $page,
                'pagesize' => $perPage,
            ],
        ]);
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        return $this->formatSubscribers($result->get('body'));
    }

    public function getDetails(string $email)
    {
        return $this->makeCall('subscribers/' . $this->getListID(), [
            'query' => [
                'email' => trim($email),
                'includetrackingpreference' => true
            ],
            'stream' => true,
            'auth' => $this->getAuthInformation()
        ]);
    }

    //Create
    public function add(array $subscriber_data)
    {
        $result = $this->makeCall('subscribers/' . $this->getListID(), [
            'json' => $subscriber_data,
        ], 'post');
        if ($result->get('code') != '201') {
            throw new Exception($result->get('body'));
        }
        return;
    }

    public function subscribe(string $email, string $name = null)
    {
        $this->add([
            'Resubscribe' => true,
            'ConsentToTrack' => 'Yes',
            'Name' => $name,
            'EmailAddress' => trim($email),
        ]);
        return;
    }

    //Resubscribe
    public function resubscribe(string $email)
    {
        $result = $this->makeCall('subscribers/' . $this->getListID(), [
            'query' => [
                'email' => trim($email)
            ],
            'json' => [
                'Resubscribe' => true,
                'ConsentToTrack' => 'Yes'
            ]
        ], 'put');
        if ($result->get('code') == '200') {
            return true;
        }
        return false;
    }

    //Remove
    public function remove(string $email)
    {
        $result = $this->makeCall('subscribers/' . $this->getListID() . '/unsubscribe', [
            'json' => ['EmailAddress' => trim($email)],
        ], 'post');
        //dd($result);
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        return;
    }

    //Update
    public function update(string $email, array $data)
    {
        $result = $this->makeCall('subscribers/' . $this->getListID(), [
            'query' => trim($email),
            'json' => [
                'EmailAddress' => trim($email),
                'Name' => $data['Name'],
                'RestartSubscriptionBasedAutoresponders' => true,
                'ConsentToTrack' => 'Unchanged',
            ]
        ], 'put');
    }

    //Import
    public function import(Request $request, $field = 'excel')
    {
        //Handle upload and populate result
        $this->importFile($this->handleUpload($request, $field, '/xls'));
        //Process subscriber list
        $subscribers['Subscribers'] = [];
        $subscribers['Resubscribe'] = true;
        $subscribers['QueueSubscriptionBasedAutoResponders'] = false;
        $subscribers['RestartSubscriptionBasedAutoresponders'] = false;
        foreach ($this->results->first() as $k => $result) {
            $subscribers['Subscribers'][] = array_merge($result->toArray(), ['ConsentToTrack' => 'Yes']);
        }

        //Set list ID
        $this->setListID($request->get('listID'));
        //Sync to CM
        $result = $this->makeCall('subscribers/' . $this->getListID() . '/import', [
            'json' => $subscribers,
        ], 'post');
        if ($result->get('code') != '201') {
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }
}
