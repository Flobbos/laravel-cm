<?php


return [
    //Your client API Key from CM
    'client_api_key' => 'acaeecea00d65c69ae3adfb47ed69f3984c4617feabc19a0',
    //The client ID from CM
    'client_id' => 'fcb039bee280ac2a38d376203bf16745',
    //If you already have a list
    'default_list_id' => '19739853070514151a1b374191a4fa18',
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
];
