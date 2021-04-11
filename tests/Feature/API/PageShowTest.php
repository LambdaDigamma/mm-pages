<?php

use LambdaDigamma\MMPages\Models\Page;

use function Pest\Laravel\get;

test('show feed (/api/v1/pages/id)', function () {
    $page1 = Page::factory()->create();

    get("/api/v1/pages/{$page1->id}")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id', 'slug', 'title', 'created_at', 'updated_at', 'deleted_at',
                'blocks' => [],
            ],
        ]);
});
