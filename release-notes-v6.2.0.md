# Laravel CM v6.2.0 Release Notes

## What's New

### ✅ Laravel 13 Support

This release adds full compatibility with **Laravel 13**. The `illuminate/support` dependency constraint has been updated to support versions 11, 12, and 13.

---

## Bug Fixes

### 🐛 Subscriber Import Was Completely Broken
A `dd($request->all())` debug statement was left in `SubscriberController::import()`, meaning **every single import request halted** and dumped raw data to the browser. This has been removed and the import flow now works as intended.

### 🐛 Subscriber Update Sent Malformed API Request
`Subscribers::update()` was passing a plain string to Guzzle's `'query'` option instead of an array. This caused malformed API requests to Campaign Monitor. The query parameter is now correctly formatted as `['email' => $email]`.

### 🐛 `initGuzzle()` Ignored Its Parameter
`BaseClient::initGuzzle(?string $base_uri)` accepted a `$base_uri` argument but never used it — both branches of the `if` statement always read from config. The parameter is now correctly applied via `$base_uri ?? config('laravel-cm.base_uri')`.

---

## Breaking Changes

### ⚠️ Routes Now Use FQCN Array Syntax
The `'namespace'` option in `Route::group()` was deprecated in Laravel 9 and removed in Laravel 11. Package routes have been updated to use the modern array syntax:

```php
// Before (broken on Laravel 11+)
Route::group(['namespace' => 'Flobbos\LaravelCM\Controllers', ...], function () {
    Route::get('/', 'NewsletterController@index');
});

// After
Route::group([...], function () {
    Route::get('/', [NewsletterController::class, 'index']);
});
```

### ⚠️ Custom `emails` Validation Rule Replaced
The `Validator::extend('emails', ...)` call in the service provider was deprecated since Laravel 10. It has been replaced with a proper `ValidationRule` class:

```php
use Flobbos\LaravelCM\Rules\CommaSeparatedEmails;

// Usage in your own controllers:
$request->validate([
    'emails' => ['required', new CommaSeparatedEmails(5)],
]);
```

The package's built-in `CampaignController` uses this rule automatically. If you were referencing the `'emails'` string rule anywhere in your own code, switch to `new CommaSeparatedEmails()`.

---

## Code Quality

- Removed all leftover `dd()` and `//dd()` debug artifacts scattered across `Campaigns`, `Subscribers`, `ResultFormat`, and controllers
- Fixed `app_path('/Models')` double-slash path typo in the service provider
- Replaced deprecated `str_slug()` global helper with `Str::slug()` in `BaseImport`
- Removed unreachable dead code (second `return` statement) in `Templates::getTemplateViewPath()`
- Removed pointless bare `return;` from `BaseClient::checkOptions()`
- Added typed property declarations to `BaseClient`
- Updated `ResultFormatContract` interface signatures to match concrete implementation
- Removed unused `Validator` facade import from the service provider

---

## Upgrade Guide

1. Update your `composer.json` to require the new version:

```bash
composer require flobbos/laravel-cm:^6.2
```

2. **If you referenced the `'emails'` string validation rule** in your own controllers, replace it:

```php
// Before
'emails' => 'required|emails'

// After
use Flobbos\LaravelCM\Rules\CommaSeparatedEmails;

'emails' => ['required', new CommaSeparatedEmails(config('laravel-cm.max_test_emails', 5))]
```

3. No config or migration changes are required.

---

## Full Changelog

See [changelog.md](./changelog.md) for the complete version history.
