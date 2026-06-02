<?php

use App\Models\NewsletterTemplate;
use Flobbos\LaravelCM\Contracts\CampaignContract;
use Flobbos\LaravelCM\Contracts\ListContract;
use Flobbos\LaravelCM\Contracts\SubscriberContract;
use Flobbos\LaravelCM\Contracts\TemplateContract;
use Flobbos\LaravelCM\Templates;

/**
 * Persist a template with an explicit created_at so ordering is deterministic.
 * Setting the timestamps before save() marks them dirty, so Eloquent keeps them
 * instead of overwriting with the current time.
 */
function makeTemplate(string $name, string $createdAt): NewsletterTemplate
{
    $template = new NewsletterTemplate([
        'template_name' => $name,
        'layout' => 'base',
        'title' => ucfirst($name),
    ]);
    $template->created_at = $createdAt;
    $template->updated_at = $createdAt;
    $template->save();

    return $template;
}

it('binds every service contract in the container', function () {
    expect(app()->bound(TemplateContract::class))->toBeTrue()
        ->and(app()->bound(CampaignContract::class))->toBeTrue()
        ->and(app()->bound(ListContract::class))->toBeTrue()
        ->and(app()->bound(SubscriberContract::class))->toBeTrue();
});

it('resolves the template contract to the Templates service', function () {
    expect(app(TemplateContract::class))->toBeInstanceOf(Templates::class);
});

it('orders templates by a column descending', function () {
    makeTemplate('alpha', '2020-01-01 00:00:00');
    makeTemplate('bravo', '2022-01-01 00:00:00');
    makeTemplate('charlie', '2021-01-01 00:00:00');

    $ordered = app(TemplateContract::class)
        ->orderBy('created_at', 'desc')
        ->get();

    expect($ordered->pluck('template_name')->all())
        ->toBe(['bravo', 'charlie', 'alpha']);
});

it('orders templates ascending by default', function () {
    makeTemplate('alpha', '2020-01-01 00:00:00');
    makeTemplate('bravo', '2022-01-01 00:00:00');
    makeTemplate('charlie', '2021-01-01 00:00:00');

    $ordered = app(TemplateContract::class)
        ->orderBy('created_at')
        ->get();

    expect($ordered->pluck('template_name')->all())
        ->toBe(['alpha', 'charlie', 'bravo']);
});

it('returns the service instance from orderBy so calls can be chained', function () {
    $service = app(TemplateContract::class);

    expect($service->orderBy('created_at', 'desc'))->toBe($service);
});

it('gets all templates', function () {
    makeTemplate('alpha', '2020-01-01 00:00:00');
    makeTemplate('bravo', '2021-01-01 00:00:00');

    expect(app(TemplateContract::class)->get())->toHaveCount(2);
});

it('creates and finds a template', function () {
    $service = app(TemplateContract::class);

    $created = $service->create([
        'template_name' => 'welcome',
        'layout' => 'base',
        'title' => 'Welcome',
    ]);

    expect($service->find($created->id)->template_name)->toBe('welcome');
});
