<?php

namespace LambdaDigamma\MMPages\Http\Controllers\Admin;

use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Http\Requests\UpdatePageBlockSlotOrderRequest;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;

class PageBlockSlotOrderController extends Controller
{
    public function update(UpdatePageBlockSlotOrderRequest $request, Page $page)
    {
        $blocks = collect($request->blocks)->sortBy('order')->all();

        batch()->update(new PageBlock, $blocks, 'id');

        return redirect()->back()->with('success', 'Der Block wurde verschoben.');
    }
}
