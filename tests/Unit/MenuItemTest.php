<?php

use LambdaDigamma\MMPages\Models\MenuItem;
use LambdaDigamma\MMPages\Models\Page;

test('menu item can be created', function () {
    $menuItem = MenuItem::create(['title' => 'Test']);
    expect($menuItem->id)->not->toBe(null);
    expect($menuItem->title)->not->toBe(null);
});

test('menu item can have children', function () {
    $parent = MenuItem::create(['title' => 'Parent']);
    $child = MenuItem::create(['title' => 'Child']);

    $parent->children()->saveMany([$child]);

    expect($child->parent_id)->toBe($parent->id);
});

test('menu item can have parent', function () {
    $parent = MenuItem::create(['title' => 'Parent']);
    $child = MenuItem::create(['title' => 'Child']);

    $child->parent()->associate($parent);
    
    expect($child->parent_id)->toBe($parent->id);
});

test('menu item can have page', function () {
    $item = MenuItem::create(['title' => 'Menu Item']);
    $page = Page::factory()->create();

    $item->page()->associate($page);
    expect($item->page_id)->toBe($page->id);
});