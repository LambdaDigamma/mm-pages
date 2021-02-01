<?php

namespace LambdaDigamma\MMPages\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Http\Requests\StoreBlockRequest;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;

class PageBlocksController extends Controller
{
    /**
     * Creates a new block based on the given
     * type with the right data structure.
     *
     * @param \LambdaDigamma\MMPages\Http\Requests\StoreBlockRequest $request
     * @param \LambdaDigamma\MMPages\Models\Page                     $page
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreBlockRequest $request, Page $page)
    {
        $block = PageBlock::make($request->validated());

        ray($block);

        $page->blocks()->saveMany([$block]);

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Block wurde hinzugefügt.');
    }
}
