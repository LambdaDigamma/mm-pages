<?php

use Illuminate\Support\Carbon;
use LambdaDigamma\MMPages\Models\PageBlock;
use Orchestra\Testbench\Factories\UserFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('unpublished page block can be published now', function () {
    actingAs(UserFactory::new()->create());
    $block = PageBlock::factory()->create();
    expect($block->published_at)->toBeNull();

    postJson("/admin/blocks/{$block->id}/publish")->assertStatus(200);
    expect(PageBlock::find($block->id)->published_at)->not->toBeNull();
});

test('unpublished page block can be published at specific time', function () {
    actingAs(UserFactory::new()->create());
    $block = PageBlock::factory()->create();
    expect($block->published_at)->toBeNull();

    $publishAt = Carbon::now()->addMinutes(60);

    postJson("/admin/blocks/{$block->id}/publish", [
        'published_at' => $publishAt->toDateTimeString(),
    ])->assertStatus(200);
    expect(PageBlock::query()->withNotPublished()->find($block->id)->published_at->toDateTimeString())
        ->toBe($publishAt->toDateTimeString());
});

test('published page block can be unpublished', function () {
    actingAs(UserFactory::new()->create());
    $block = PageBlock::factory()->published()->create();
    expect($block->published_at)->not->toBeNull();

    postJson("/admin/blocks/{$block->id}/unpublish")->assertStatus(200);
    expect(PageBlock::query()->withNotPublished()->find($block->id)->published_at)
        ->toBeNull();
});
