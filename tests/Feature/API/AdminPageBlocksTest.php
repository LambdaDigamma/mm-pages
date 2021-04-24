<?php

use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;
use Orchestra\Testbench\Factories\UserFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('show page blocks (/api/v1/pages/blocks)', function () {
    $user = UserFactory::new()->create();
    actingAs($user);
    $page1 = Page::factory()->published()->create();
    $blocks = PageBlock::factory()->count(3)->make();
    $page1->blocks()->saveMany($blocks);

    get("/api/v1/admin/pages/{$page1->id}/blocks")
        ->assertStatus(200)
        ->assertJsonCount(3, "data")
        ->assertJsonStructure([
            'data' => [
                ['id', 'type', 'data']
            ]
        ]);
});
