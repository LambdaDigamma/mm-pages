<?php

namespace LambdaDigamma\MMPages\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageTemplate;

class PageTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

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

}
