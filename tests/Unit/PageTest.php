<?php

namespace LambdaDigamma\MMPages\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use LambdaDigamma\MMPages\Models\MenuItem;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;
use LambdaDigamma\MMPages\Models\PageTemplate;
use LambdaDigamma\MMPages\Tests\TestCase;

class PageTest extends TestCase
{
    use DatabaseMigrations;

    public function test_page_can_have_page_template()
    {
        $pageTemplate = PageTemplate::factory()
            ->create();

        $page = Page::factory()
            ->create();

        $this->assertNull($page->pageTemplate);

        $page->pageTemplate()->associate($pageTemplate);
        $page->save();

        $this->assertNotNull($page->pageTemplate);
        $this->assertEquals($page->pageTemplate->id, $pageTemplate->id);
    }

    public function test_page_can_have_page_blocks()
    {
        $pageBlocks = PageBlock::factory()->published()->count(3)->create();
        $page = Page::factory()->published()->create();

        $this->assertCount(0, $page->blocks);
        $page->blocks()->saveMany($pageBlocks);
        $page->load('blocks');
        $this->assertCount(3, $page->blocks);
    }

    public function test_page_can_have_menu_item()
    {
        $page = Page::factory()->published()->create();
        $item = MenuItem::factory()->create();

        $page->menuItem()->save($item);
        $this->assertEquals($item->page_id, $page->id);
    }

    public function test_page_can_have_parent_menu_item()
    {
        $page = Page::factory()->published()->create();
        $item = MenuItem::factory()->create();

        $page->parentMenuItem()->associate($item);
        $this->assertEquals($page->parent_menu_item_id, $item->id);
    }

    public function test_page_to_array()
    {

        $page = Page::factory()->published()->create(['title' => ['en' => 'Test Page']]);
        $page->setTranslation('title', 'de', 'Test Seite');
        $page->setTranslation('title', 'fr', 'Test Page');

        $this->app->setLocale('en');
        $this->assertEquals('Test Page', $page->toArray()['title']);

        $this->app->setLocale('de');
        $this->assertEquals('Test Seite', $page->toArray()['title']);

    }
}
