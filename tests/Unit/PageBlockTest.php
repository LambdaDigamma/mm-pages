<?php

namespace LambdaDigamma\MMPages\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;
use LambdaDigamma\MMPages\Tests\TestCase;
use Spatie\TestTime\TestTime;

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

    /** @test */
    public function a_published_page_block_can_be_expired()
    {
        $block = PageBlock::factory()->published()->create();
        $this->assertNotNull($block->published_at);
        $this->assertNull($block->expired_at);

        $block->expire();
        $this->assertNotNull($block->expired_at);
    }

    /** @test */
    public function a_published_page_block_can_be_expired_at_specific_time_and_not_be_accessed_after()
    {
        $block = PageBlock::factory()->published()->create();
        $this->assertNotNull($block->published_at);
        $this->assertNull($block->expired_at);

        $block->expireAt(Carbon::parse('2021-03-31 21:00:00'));
        $this->assertEquals('2021-03-31 21:00:00', $block->fresh()->expired_at->toDateTimeString());

        TestTime::freeze('Y-m-d H:i:s', '2021-03-31 21:10:00');

        $this->assertCount(0, PageBlock::all());
    }

    /** @test */
    public function a_published_expired_page_block_can_be_unexpired()
    {
        $block = PageBlock::factory()->published()->expired()->create();
        $this->assertNotNull($block->published_at);
        $this->assertNotNull($block->expired_at);

        $block->unexpire();
        $this->assertNull($block->expired_at);
    }
}
