<?php

use LambdaDigamma\MMPages\Models\MenuItem;
use Orchestra\Testbench\Factories\UserFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

test('editor can retrieve all menu items', function () {
    $user = UserFactory::new()->create();
    actingAs($user);
    $menuItems = MenuItem::factory()->count(4)->create();

    getJson('/admin/editor/menu')
        ->assertStatus(200)
        ->assertJsonCount(4)
        ->assertJsonStructure([[
            'id',
            'title',
            'page_id',
            'parent_id',
            'order'
        ]]);
});