<?php

namespace LambdaDigamma\MMPages\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageTemplate;
use LambdaDigamma\MMPages\Tests\TestCase;

class PageTemplateTest extends TestCase
{
    use DatabaseMigrations;

    public function test_page_template_can_have_pages()
    {
        $pages = Page::factory()->published()->count(3)->create();
        $pageTemplate = PageTemplate::factory()->create();

        $this->assertCount(0, $pageTemplate->pages);
        $pageTemplate->pages()->saveMany($pages);
        $pageTemplate->load('pages');
        $this->assertCount(3, $pageTemplate->pages);
    }
}
