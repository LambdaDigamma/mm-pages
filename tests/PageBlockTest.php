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
}
