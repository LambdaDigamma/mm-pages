<?php

namespace LambdaDigamma\MMPages\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;
use LambdaDigamma\MMPages\Tests\TestCase;
use Orchestra\Testbench\Factories\UserFactory;

class UpdateBlockOrderRequestTest extends TestCase
{
    use DatabaseMigrations;

    public function test_update_with_two_blocks()
    {
        $page = Page::factory()
            ->published()
            ->has(PageBlock::factory()->published()->count(2), 'blocks')
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
