<?php

use LambdaDigamma\MMPages\Models\PageBlock;
use Orchestra\Testbench\Factories\UserFactory;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;

test('page block can be deleted', function () {
    actingAs(UserFactory::new()->create());
    $block = PageBlock::factory()->create();
    expect($block->deleted_at)->toBeNull();

    deleteJson("/admin/blocks/{$block->id}")->assertStatus(200);
    expect(PageBlock::query()->withTrashed()->withNotPublished()->find($block->id)->deleted_at)->not->toBeNull();
});

test('page block can be force deleted', function () {
    actingAs(UserFactory::new()->create());
    $block = PageBlock::factory()->create();
    expect($block->deleted_at)->toBeNull();

    deleteJson("/admin/blocks/{$block->id}", ['force' => true])->assertStatus(200);
    expect(PageBlock::query()->withTrashed()->withNotPublished()->find($block->id))->toBeNull();
});

test('page block can be restored', function () {
    actingAs(UserFactory::new()->create());
    $block = PageBlock::factory()->create();
    $block->delete();
    expect($block->deleted_at)->not->toBeNull();

    postJson("/admin/blocks/{$block->id}/restore")->assertStatus(200);
    expect(PageBlock::query()->withTrashed()->withNotPublished()->find($block->id)->deleted_at)->toBeNull();
});