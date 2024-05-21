<?php

namespace LambdaDigamma\MMPages\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Http\Requests\DeletePageBlockRequest;
use LambdaDigamma\MMPages\Http\Requests\StoreBlockRequest;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;

class PageBlocksController extends Controller
{
    /**
     * Creates a new block based on the given
     * type with the right data structure.
     *
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreBlockRequest $request, Page $page)
    {
        $block = PageBlock::make($request->validated());

        $page->blocks()->saveMany([$block]);

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Block wurde hinzugefügt.');
    }

    public function delete(DeletePageBlockRequest $request, PageBlock $block)
    {
        if ($request->force) {
            $block->forceDelete();
        } else {
            $block->delete();
        }

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Block wurde gelöscht.');
    }

    public function restore(Request $request, PageBlock $block)
    {
        $block->restore();

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Block wurde wiederhergestellt.');
    }
}
