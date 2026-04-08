## Version History

### v. 6.2.0

- Added support for Laravel 13
- Bumped `illuminate/support` constraint to `11.*|12.*|13.*`
- **Routes**: Removed deprecated `namespace` group option — controllers now use FQCN array syntax
- **ServiceProvider**: Removed deprecated `Validator::extend()` — replaced with `CommaSeparatedEmails` rule class; fixed `app_path('/Models')` path typo
- **BaseClient**: Fixed `initGuzzle()` bug where `$base_uri` param was ignored; added typed properties; removed bare `return;` from `checkOptions()`
- **Subscribers**: Fixed `update()` where `'query'` was a string instead of an array; removed `//dd()` debug comment from `remove()`
- **SubscriberController**: Removed `dd($request->all())` that blocked every import request
- **CampaignController**: Removed `//dd()` debug comments; uses new `CommaSeparatedEmails` validation rule
- **Templates**: Removed unreachable dead-code second `return` in `getTemplateViewPath()`
- **ResultFormat**: Removed `//dd()` debug comment; added typed return signatures
- **ResultFormatContract**: Updated interface signatures to match concrete implementation
- **BaseImport**: Replaced deprecated `str_slug()` with `Str::slug()`

### v. 6.1.4

- Fixed single-layout mode to enforce default layout when no layout is specified
- Restored `public/storage` symlink creation in install command (fixes inaccessible compiled templates)
- Updated generated controller stub to use correct storage path for template files
- Hardened layout resolution in Templates service with null-safe lookups

### v. 6.1.3

- Switched default template source location to storage while keeping layouts in resources
- Added `template_location` and `template_storage_path` configuration options
- Updated install/deployment migration to preserve existing files and avoid overwriting layouts/templates
- Removed legacy full `resources/laravel-cm` symlink workflow in favor of split layout/template handling

### v. 6.1.2

- Fixed a hardcoded path in the stubs
- Updated Readme
- Updated a few titles with translated strings

### v. 6.1.1

- Addresses an issue where SASS files weren't handled correctly by the RemoteCompiler class

### v. 6.1.0

- Fixed remote compiler to be compatible with new version

### v. 6.0.1

- Added support for Laravel 12
- Fixed old validation code

### v. 6.0.0

- Added support for Laravel 11

### v. 5.0.0

- Added support for Laravel 10

### v. 4.0.3

- Fixed dashboard problem

### v. 4.0.2

- Fixed route issue

### v. 4.0.1

- Fixed storage issue

### v. 4.0.0

- Initial Laravel 9 support

### v. 3.0.3

- PHP 8 updates

### v. 3.0.2

- Removed implicit dependency on Laravel Breeze
- Added custom drop down and menu items

### v. 3.0.1

- Added a responsive menu snippet for Tailwind

### v. 3.0.0

- Added support for Laravel 8
- Added support for TailwindCSS
