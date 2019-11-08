<?php


return [
    //Your client API Key from CM
    'client_api_key' => 'your secret key',
    //The client ID from CM
    'client_id' => 'your client ID',
    //If you already have a list
    'default_list_id' => '',
    //Base URI for setting up Guzzle
    'base_uri' => 'https://api.createsend.com/api/v3.2/',
    //Storage path for uploaded imports
    'storage_path' => 'xls',
    //URL path where to load api
    'url_path'=>'newsletters',
    //Default format to use JSON|XML
    'format' => 'json',
    //Confirmation emails
    'confirmation_emails' => 'you@example.com,xyz@example.com',
    //Confirmation URL
    'subscribe_success' => 'http://example.com/success',
    //Unsubscribe URL
    'unsubscribe_success' => 'http://example.com/unsubscribe_success',
    //Standard from name
    'from_name' => 'Your Company',
    //Standard from address
    'from_email' => 'newsletter@example.com',
    //Standard reply to address
    'reply_to' => 'replies@example.com',
    //Front-end
    'layout_file' => 'admin',
    // Max. email-addresse for test-sending
    'max_test_emails' => 5,
    //Default testing address
    'test_email' => 'tester@example.com',
    //Default testing subject
    'test_subject' => 'Campaign Preview',
    
    //Remote compiler option
    'use_api' => false,
    //Regular Foundation Emails
    //'api_url' => 'https://blinky.ultrabold.net/api/generate',
    //MJML compiler
    //'api_url' => 'https://blinky.ultrabold.net/api/mjml/generate',
    'api_url' => '',
    'api_token' => '',
    //Your bootstrap version
    'bootstrap' => 4,
];
