<?php

use LambdaDigamma\MMPages\Models\Page;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

test('show feed (/api/v1/pages/id)', function () {
    $page1 = Page::factory()->published()->create();

    getJson("/api/v1/pages/{$page1->id}")
        ->assertStatus(200)
        ->assertHeader('Etag')
        ->assertHeader('Cache-Control', 'max-age=3600, public')
        ->assertJsonStructure([
            'data' => [
                'id', 'slug', 'title', 'created_at', 'updated_at', 'deleted_at',
                'blocks' => [],
            ],
        ]);
});
