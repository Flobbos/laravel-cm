<?php


return [
    //Multi layout option
    'multi_layout' => false,
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
    'url_path' => 'newsletters',
    //Folder where you want to keep your templates
    'layout_path' => 'laravel-cm/layouts',
    //Default layout
    'base_layout' => 'base',
    //Folder where you want to keep your templates
    'template_path' => 'laravel-cm/templates',
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
    //Default newsletter template route
    'newsletter_template_route' => 'admin.newsletter-templates.',
    // Max. email-addresse for test-sending
    'max_test_emails' => 5,
    //Default testing address
    'test_email' => 'tester@example.com',
    //Default testing subject
    'test_subject' => 'Campaign Preview',
    //Asset path
    'asset_path' => 'laravel-cm-assets',
    //MJML compiler
    'api_url' => 'https://blinky.ultrabold.net/api/mjml/generate',
    'api_token' => '',
    //Your css framework bootstrap4 or tailwind
    'css_framework' => 'tailwind',
    //Middleware to apply to the CM Routes
    'middleware' => ['web', 'auth'],
];
