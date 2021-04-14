<?php

use Illuminate\Support\Carbon;
use LambdaDigamma\MMFeeds\Models\Post;
use LambdaDigamma\MMPages\Models\Page;
use Orchestra\Testbench\Factories\UserFactory;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('unpublished page can be published now', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->create();
    expect($page->published_at)->toBeNull();

    postJson("/admin/pages/{$page->id}/publish")->assertStatus(200);
    expect(Page::find($page->id)->published_at)->not->toBeNull();
});

test('unpublished page can be published at specific time', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->create();
    expect($page->published_at)->toBeNull();

    $publishAt = Carbon::now()->addMinutes(60);

    postJson("/admin/pages/{$page->id}/publish", [
        'published_at' => $publishAt->toDateTimeString(),
    ])->assertStatus(200);
    expect(Page::query()->withNotPublished()->find($page->id)->published_at->toDateTimeString())
        ->toBe($publishAt->toDateTimeString());
});

test('published page can be unpublished', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->published()->create();
    expect($page->published_at)->not->toBeNull();

    postJson("/admin/pages/{$page->id}/unpublish")->assertStatus(200);
    expect(Page::query()->withNotPublished()->find($page->id)->published_at)
        ->toBeNull();
});
