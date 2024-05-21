<?php

use Illuminate\Support\Carbon;
use LambdaDigamma\MMPages\Models\PageBlock;
use Orchestra\Testbench\Factories\UserFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('page block can be expired now', function () {
    actingAs(UserFactory::new()->create());
    $block = PageBlock::factory()->create();
    expect($block->expired_at)->toBeNull();

    postJson("/admin/blocks/{$block->id}/expire")->assertStatus(200);

    $b = PageBlock::query()->withNotPublished()->withExpired()->find($block->id);
    expect($b->expired_at)->not->toBeNull();
});

test('unpublished page block can be expired at specific time', function () {
    actingAs(UserFactory::new()->create());
    $block = PageBlock::factory()->create();
    expect($block->expired_at)->toBeNull();

    $expireAt = Carbon::now()->addMinutes(60);

    postJson("/admin/blocks/{$block->id}/expire", [
        'expired_at' => $expireAt->toDateTimeString(),
    ])->assertStatus(200)->assertJsonStructure([
        'id',
        'expired_at',
    ]);
    expect(PageBlock::query()->withNotPublished()->find($block->id)->expired_at->toDateTimeString())
        ->toBe($expireAt->toDateTimeString());
});

test('published expired page block can be unexpired', function () {
    actingAs(UserFactory::new()->create());
    $block = PageBlock::factory()->published()->expired()->create();
    expect($block->expired_at)->not->toBeNull();

    postJson("/admin/blocks/{$block->id}/unexpire")->assertStatus(200);
    expect(PageBlock::query()->withNotPublished()->find($block->id)->expired_at)
        ->toBeNull();
});
