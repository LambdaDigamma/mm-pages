<?php

use LambdaDigamma\MMPages\Models\Page;
use Orchestra\Testbench\Factories\UserFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;

test('page can be deleted', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->create();
    expect($page->deleted_at)->toBeNull();

    deleteJson("/admin/pages/{$page->id}")->assertStatus(200);
    expect(Page::query()->withTrashed()->withNotPublished()->find($page->id)->deleted_at)->not->toBeNull();
});

test('page can be force deleted', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->create();
    expect($page->deleted_at)->toBeNull();

    deleteJson("/admin/pages/{$page->id}", ['force' => true])->assertStatus(200);
    expect(Page::query()->withTrashed()->withNotPublished()->find($page->id))->toBeNull();
});

test('page can be restored', function () {
    actingAs(UserFactory::new()->create());
    $page = Page::factory()->create();
    $page->delete();
    expect($page->deleted_at)->not->toBeNull();

    postJson("/admin/pages/{$page->id}/restore")->assertStatus(200);
    expect(Page::query()->withTrashed()->withNotPublished()->find($page->id)->deleted_at)->toBeNull();
});
