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
composer require flobbos/laravel-crudable
```

Next, if you plan on using the Contract with automated binding,
add the service provider to `app/config/app.php`

```
Flobbos\Crudable\CrudableServiceProvider::class,
```