<?php

namespace LambdaDigamma\MMPages\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageTemplate;

class PageTemplateTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_page_template_can_have_pages()
    {
        $pages = Page::factory()->count(3)->create();
        $pageTemplate = PageTemplate::factory()->create();

        $this->assertCount(0, $pageTemplate->pages);
        $pageTemplate->pages()->saveMany($pages);
        $pageTemplate->load('pages');
        $this->assertCount(3, $pageTemplate->pages);
    }
}
