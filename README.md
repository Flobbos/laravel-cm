# Laravel-CM

![Laravel CM](img/laravel-cm.png)

**Integration for the v3.2 Campagin Monitor API**

This package allows you to generate templates using your own resources and 
submit them to Campaign Monitor as content for your newsletter issues.
It comes complete with a CRUD implementation for saving your content templates
in the DB. 

### Docs

* [Installation](#installation)
* [Configuration](#configuration)
* [Generators](#generators)
* [Usage](#usage)
* [Functions](#functions)
* [Exceptions](#exceptions)
* [Laravel compatibility](#laravel-compatibility)

## Installation 

### Install package

Add the package in your composer.json by executing the command.

```bash
composer require flobbos/laravel-cm
```

Next, add the service provider to `app/config/app.php`

```
Flobbos\Crudable\CrudableServiceProvider::class,
```

## Configuration

### Publish configuration file

Laravel 5.*
```bash
php artisan vendor:publish 
```

### Client API Key

Set your Campaign Monitor client API key here to have access to the API. 

```php
'client_api_key' => 'your secret key'
```

### Client ID

Set your Campaign Monitor client ID. 

```php
'client_id' => 'your client ID'
```

### Default list ID

If you have created a list at Campaign Monitor you can set a default list. If 
not you can create a list using the API and insert it here later. 

```php
'default_list_id' => 'your default list ID'
```

### Base URI

This is the base URI where the Campaign Monitor API is being called. This might
change in the future with new releases of their API. For now, don't touch it.

```php
'base_uri' => 'https://api.createsend.com/api/v3.2/'
```

### Storage path

If you plan on importing XLS files with email addresses this determines the 
storage path used for it. 

```php
'storage_path' => 'xls'
```

### URL Path

Determine the base route for the package. 

```php
'url_path'=>'laravel-cm'
```

### Format

Here you can set the default format being used to communicate with the API. For
the moment only JSON is supported. 

```php
'format' => 'json'
```

### Confirmation emails

By default you can have a list of up to 5 email addresses in a comma separated
list where confirmations will be sent when a campaign is sent. 

```php
'confirmation_emails' => 'you@example.com,xyz@example.com',
```

### Subscribe success

If you're using the same success page for subscriptions every time then you
can set it here so it will be automatically loaded into the forms.

```php
'subscribe_success' => 'http://example.com/success'
```

### Unsubscribe success

Same goes for unsubscribe success page. 

```php
'unsubscribe_success' => 'http://example.com/unsubscribe_success'
```

### From Email

Default sender email for campaigns. This can still be changed in the form.   

```php
'from_email' => 'newsletter@example.com'
```

### Reply-to Email

Default reply-to email for campaigns. This can still be changed in the form. 

```php
'reply_to' => 'replies@example.com'
```

### Layout file

This determines the name of the layout file the package views will extend. 

```php
'layout_file' => 'admin'
```

### Max test emails

Maximum number of preview test email addresses.

```php
'max_test_emails' => 5
```

### Test email

Default email address where preview mails are being sent to. 

```php
'test_email' => 'tester@example.com'
```

### Test subject

Default subject for preview emails

```php
'test_subject' => 'Campaign Preview'
```

## Generators

### Controller generator

With this command you can generate a boiler plate controller where you can grab
your content and generate the templates used for your campaigns.

First parameter is the controller name. The route parameter tells the generator
where the default routes for the views/controller should be and the views 
parameter tells the controller where the view path should be.

```php
php artisan laravel-cm:controller NewsletterController --route=laravel-cm.templates --views=laravel-cm.templates
```

### Views generator

This command generates the views needed for making templates to be used in 
your campaigns.

First parameter is the path where the views should be located at. Should match
the path you gave to the controller command.

```php
php artisan laravel-cm:views /view/path --route=laravel-cm.templates
```

## Usage

After the installation all you need to do is add the links to the parts of the 
package you want to use to your layout file. 

Example: 

```html
<li class="has-dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
       aria-expanded="false">
        Newsletter <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{route('laravel-cm::dashboard')}}">
                Dashboard
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="{{ route('admin.newsletters.templates.index') }}">
                Templates
            </a>
        </li>
        <li>
            <a href="{{ route('laravel-cm::campaigns.index') }}">
                Campaigns
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="{{ route('laravel-cm::lists.index') }}">
                Lists
            </a>
        </li>
        <li>
            <a href="{{ route('laravel-cm::subscribers.index') }}">
                Subscribers
            </a>
        </li>

    </ul>
</li>
```
