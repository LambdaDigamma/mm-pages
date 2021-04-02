<?php

namespace LambdaDigamma\MMPages\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;
use Orchestra\Testbench\Factories\UserFactory;

class UpdateBlockOrderRequestTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_update_with_two_blocks()
    {
        $page = Page::factory()
            ->has(PageBlock::factory()->count(2), 'blocks')
            ->create();

        $this
            ->actingAs(UserFactory::new()->create())
            ->postJson(
                "/admin/pages/{$page->id}/blocks/order",
                ['blocks' => [
                    [
                        'id' => 1,
                        'order' => 1,
                    ],
                    [
                        'id' => 2,
                        'order' => 0,
                    ],
                ],
            ]
            )
            ->assertStatus(302);

        $block1 = PageBlock::find(1);
        $block2 = PageBlock::find(2);

        $this->assertEquals(1, $block1->order);
        $this->assertEquals(0, $block2->order);
    }
}
