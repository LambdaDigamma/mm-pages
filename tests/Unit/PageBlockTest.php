<?php

namespace LambdaDigamma\MMPages\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;
use LambdaDigamma\MMPages\Tests\TestCase;

class PageBlockTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_page_block_can_have_page()
    {
        $page = Page::factory()->published()->create();
        $block = PageBlock::factory()->create();

        $this->assertNull($block->page);
        $block->page()->associate($page);
        $block->load('page');
        $this->assertEquals($block->page->id, $page->id);
    }

    /** @test */
    public function a_page_block_can_have_children_blocks()
    {
        $parentBlock = PageBlock::factory()->published()->create();
        $childBlock = PageBlock::factory()->published()->create();
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

    /** @test */
    public function a_page_block_can_be_published()
    {
        $block = PageBlock::factory()->create();
        $this->assertNull($block->published_at);

        $block->publish();
        $this->assertNotNull($block->published_at);
    }

    /** @test */
    public function a_published_page_block_can_be_unpublished()
    {
        $block = PageBlock::factory()->published()->create();
        $this->assertNotNull($block->published_at);

        $block->unpublish();
        $this->assertNull($block->published_at);
    }
}
