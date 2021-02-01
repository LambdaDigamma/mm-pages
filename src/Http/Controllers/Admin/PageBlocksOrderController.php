<?php

namespace LambdaDigamma\MMPages\Http\Controllers\Admin;

use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Http\Requests\UpdateBlockOrderRequest;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;
use Mavinoo\Batch\BatchFacade;

class PageBlocksOrderController extends Controller
{
    public function update(UpdateBlockOrderRequest $request, Page $page)
    {
        $blocks = collect($request->blocks)->sortBy('order')->all();

        BatchFacade::update(new PageBlock, $blocks, 'id');

        return redirect()->back()->with('success', 'Der Block wurde verschoben.');

//        dd(PageBlock::all());
    }
}
