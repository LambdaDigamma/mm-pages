<?php

namespace LambdaDigamma\MMPages\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;

class PageBlockTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_page_block_can_have_page()
    {
        $page = Page::factory()->create();
        $block = PageBlock::factory()->create();

        $this->assertNull($block->page);
        $block->page()->associate($page);
        $block->load('page');
        $this->assertEquals($block->page->id, $page->id);
    }

    /** @test */
    public function a_page_block_can_have_children_blocks()
    {
        $parentBlock = PageBlock::factory()->create();
        $childBlock = PageBlock::factory()->create();
        $parentBlock->children()->saveMany([$childBlock]);
        
        $this->assertEquals($parentBlock->fresh()->children->count(), 1);
    }

    /** @test */
    public function a_page_block_can_have_a_parent()
    {
        $parentBlock = PageBlock::factory()->create();
        $childBlock = PageBlock::factory()->create();
        $childBlock->parent()->associate($parentBlock);
        
        $this->assertEquals($childBlock->parent_id, $parentBlock->id);
    }
}
