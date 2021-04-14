<?php

use LambdaDigamma\MMPages\Models\Page;
use Orchestra\Testbench\Factories\UserFactory;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('page can be archived', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->published()->create();
    expect($page->archived_at)->toBeNull();

    postJson("/admin/pages/{$page->id}/archive")->assertStatus(200);
    expect(Page::query()->withNotPublished()->withArchived()->find($page->id)->archived_at)
        ->not->toBeNull();
});

test('not published page can be archived', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->create();
    expect($page->archived_at)->toBeNull();

    postJson("/admin/pages/{$page->id}/archive")->assertStatus(200);
    expect(Page::query()->withNotPublished()->withArchived()->find($page->id)->archived_at)
        ->not->toBeNull();
});

test('archived page can be unarchived', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->published()->archived()->create();
    expect($page->archived_at)->not->toBeNull();

    postJson("/admin/pages/{$page->id}/unarchive")->assertStatus(200);
    expect(Page::query()->withNotPublished()->withArchived()->find($page->id)->archived_at)->toBeNull();
});

test('archived not published page can be unarchived', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->archived()->create();
    // dd($page);
    expect($page->archived_at)->not->toBeNull();

    postJson("/admin/pages/{$page->id}/unarchive")->assertStatus(200);
    expect(Page::query()->withNotPublished()->withArchived()->find($page->id)->archived_at)->toBeNull();
});
