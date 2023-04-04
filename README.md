# Laravel-CM

![Laravel CM](img/laravel-cm.png)

**Integration for the v3.2 Campagin Monitor API**

This package allows you to generate templates using your own resources and
submit them to Campaign Monitor as content for your newsletter issues.
It comes complete with a CRUD implementation for saving your content templates
in the DB.

**As of version 2.0.0 only [MJML](https://mjml.io/) will be accepted**

**Support for Laravel 8 was moved to version 3.x**

### Docs

-   [Upgrading](#upgrading)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Assets](#assets)
-   [Generators](#generators)
-   [Usage](#usage)
-   [Exceptions](#exceptions)
-   [Laravel compatibility](#laravel-compatibility)
-   [Envoyer deployments](#envoyer-deployments)

## Upgrading

### Upgrade from Version 1.x to Version 2.x

If you have previously used LaravelCM you need to follow a few steps to make your setup compatible
with the new version of LaravelCM.

### Base Layout/Template

Since LaravelCM now offers a multi-layout solution we updated the nomenclature of the files as well
as the directory structure. You need to copy your existing template images and SCSS to the newly created
files.

```bash
../storage/app/laravel-cm/layouts/base
```

Move all your template code to base.blade.php and all your SCSS to base.scss. These should no longer be
located in an 'assets' folder. Images are copied to the 'images' folder in the base layout root directory.

### Migrating the config

LaravelCM 2.x provides a lot of new configuration variables that you need to set in order to get everything
working. If you navigate to the dashboard of LaravelCM you will notice the new configuration options in the
listing there. It is probably your best bet to delete your current configuration file and republish it from scratch.

### Migration for multi layout option

If you plan on using multiple layouts for your newsletters you need to add a field 'layouts' to your newsletter
templates table so LaravelCM can keep track of this information.

Your migration should look something like this:

```php
Schema::table('newsletter_templates', function(Blueprint $table){
    $table->string('layout')->nullable();
});
```

Once that field is added to your template model as well, you should be good to go, after running the install
command below to move the content to the appropriate locations.

### Install Command

LaravelCM 2.x features a new install command that takes care of publishing the config files and such.
However, you can also run this to move your existing template files and layouts to the storage folder so
they don't get lost after deployments.

```bash
php artisan laravel-cm:install --deployment
```

This command will only copy the existing template files from the resources folder to storage, delete the
now empty laravel-cm folder and set a symlink to the newly created storage folder.

### Upgrade from Version 2.x to Version 3.x

If you have previously used LaravelCM you need to follow a few steps to make your setup compatible
with the new version of LaravelCM.

### Migrating the config

LaravelCM 3.x changed the option 'bootstrap' to 'css_framework' in the config because you can now switch between Bootstrap4 and TailwindCSS.

### Routes Facade

Since Laravel 8 handles routes a bit differently than previous versions you need to provide the namespace of the
NewsletterTemplateController generated via command to the CMRoutes facade like mentioned below.

## Installation

### Install package

Add the package in your composer.json by executing the command.

```bash
composer require flobbos/laravel-cm
```

LaravelCM features auto discover for Laravel. In case this fails, just add the
Service Provider to the app.php file.

```
Flobbos\LaravelCM\LaravelCMServiceProvider::class,
```

### Running the installation routine

Using the new install command you are guided through the process of publishing all necessary files as well
as set up all required directories and symlinks.

```bash
php artisan laravel-cm:install
```

Follow the step by step process or alternatively you can just run everything at once. There is a prompt
for that option.

### Publish configuration file

This step is very important because it publishes the NewsletterTemplate model
to the App folder so you can set your own fillable fields as well as
relationships you may need. The template generator needs to have this model
present otherwise you will receive an error.

This also publishes the inital base layout that will be used to generate
newsletter templates.

```bash
php artisan vendor:publish --tag=laravel-cm-config
```

### Generate Controller

You need to generate the controller that handles generating the templates from
the base layout or any other layout you generated.

```bash
php artisan laravel-cm:controller NewsletterTemplateController --route=
```

You can give this command a route that will be used but you will also be asked
for it during generation. This route is where all the magic happens. The default
is admin.newsletter-template.

### Generate Views

Next up are the views you need for running your template generation

```bash
php artisan laravel-cm:views path.to.routes --route=
```

Here you need to use the route previously defined for your controller. The default
is the same but you will also be asked during the generation process.

### Migrations

During the publishing process the migration for the newsletter_templates table
was also published. Add all fields you need and run the migration.

```bash
php artisan migrate
```

### Adding the package

### Routes

Routes that are used by LaravelCM need to be added to your routes file. Since version 3.x you need to
specify the namespace of the NewsletterTemplateController generated from LaravelCM.

```php
use App\Http\Controllers\NewsletterTemplateController;

CMRoutes::load(NewsletterTemplateController::class);
```

This is all you need to do for the routes to load.

If you want to add the routes to your NewsletterTemplateController manually you
can simply add the following routes:

```php
Route::put('newsletter-template/generate-template/{id}', [NewsletterTemplateController::class, 'generateTemplate'])->name('newsletter-templates.generate-template');
Route::put('newsletter-template/update-template/{id}', [NewsletterTemplateController::class, 'updateTemplate'])->name('newsletter-templates.update-template');
Route::get('templates/{id}/send-preview', [NewsletterTemplateController::class, 'sendPreview'])->name('newsletter-templates.send-preview');
Route::resource('newsletter-templates', NewsletterTemplateController::class)
```

### Menu items

If you're using a standard Boostrap4 or Tailwind top bar menu you can simply include all
necessary links with a dropdown like so:

```php
@include('laravel-cm::menu')
```

In your main layout blade file or where ever your top bar is located.

### Tailwind responsive menu

Since the switch to Tailwind the default Laravel menu has a responsive menu. Just include
the provided menu where the rest of the responsive Laravel menu is located.

```php
@include('laravel-cm::menu-responsive')
```

That's it. You're ready to roll. Let's move on to the configuration

## Configuration

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

### Remote compiler

All compiling is done via remote compiler, which is offered free of charge for
all users of this package. Simply contact me for a valid API key to handle
your remove compiling needs based on MJML. Set the token here

```php
'api_token' => '',
```

### CSS Framework

You can now select which CSS framework you want to use. You have the option of using Bootstrap4 or
TailwindCSS. Depending on this selection LaravelCM will automatically load the appropriate views.

```php
//bootstrap or tailwind
'css_framework' => 'tailwind',
```

## Assets

### Naming conventions

A default layout file is provided for you to work with. Additional layout files
can be generated depending on what you need. The folder structure is simple and
as follows:

```php
/resources
    /defaults
        /base
            base.blade.php
            base.scss
```

This folder will get copied into your resources folder and you should put your
default layout design into these files. You can also add an images folder
which will also get copied once a new template gets generated.

The default should only contain your base layout. Subsequent changes should be
made to the files that have been generated for a particular newsletter template.

## Generators

### Controller generator

With this command you can generate a boiler plate controller where you can grab
your content and generate the templates used for your campaigns.

First parameter is the controller name. The route parameter tells the generator
where the default routes for the views/controller should be and the views
parameter tells the controller where the view path should be.

```php
php artisan laravel-cm:controller NewsletterController --route=admin.newsletter-template --views=laravel-cm.templates
```

### Views generator

This command generates the views needed for making templates to be used in
your campaigns.

First parameter is the path where the views should be located at. Should match
the path you gave to the controller command.

```php
php artisan laravel-cm:views /view/path --route=laravel-cm.templates
```

### Layouts Generator

You can generate a new layout by simply using the following command. This will
generate a new blank layout file for you to edit.

```php
php artisan laravel-cm:layout name-of-layout
```

## Usage

### Dashboard

The dashboard contains an overview of your config settings and a mini
documentation on how to use the package.

### Campaigns

The campaigns overview shows your draft/scheduled/sent campaigns that were
retrieved from Campaign Monitor via API. Here you can create/schedule/preview
your campaigns as well as view basic statistical information.

### Lists

The lists section lets you create/edit different email lists that are synced
to Campaign Monitor. Here you can also view basic statistical information about
your list such as subscribes/unsubscribes/bounces.

### Subscribers

Here you can view all your subscriber information across different lists that
you can select. It also gives you the option to import large amounts of
subscribers from and XLS file. The format should be:

```xls
EmailAddress    Name
```

Be careful if the subscribers are already confirmed and are imported into a
double-opt-in list, they will all receive a confirmation email where they
basically have to resubscribe.

You can also manually unsubscribe users as well as resubscribe them and view
basic information about your subscribers.

## Exceptions

### ConfigKeyNotSetException

This exception will be thrown if a configuration key is missing from your
config file but is needed to perform a certain API call.

### TemplateNotFoundException

This exception happens when you try to use a template that doesn't physically
exist.

## Laravel compatibility

| Laravel | LaravelCM     |
| :------ | :------------ |
| 10.x    | >5.0.\*       |
| 9.x     | >4.0.\*       |
| 8.x     | >3.0.\*       |
| 7.x     | >2.0.\*       |
| 6.x     | >2.0.\*       |
| 5.8     | >2.0.\*       |
| 5.7     | >2.0.\*       |
| 5.6     | >=1.0.0/2.0.0 |
| 5.5     | >=1.0.0/2.0.0 |
| 5.4     | >=1.0.0       |
| 5.3     | >=1.0.0       |

Lower versions of Laravel are not supported.

## Envoyer deployments

If you're using Envoyer or something similar to deploy your code, there's a solution to
keeping your existing templates and compiled newsletters. During the deployment all you
need to do is run the following command:

```bash
php artisan laravel-cm:install --deployment
```

This will run a function that moves all existing stuff to the new installation and takes care
of recreating the necessary symlinks for everything to work.
