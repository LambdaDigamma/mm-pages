<?php

namespace LambdaDigamma\MMPages\Http\Controllers\API;

use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;

class AdminPageBlocksController extends Controller
{
    public function index($pageId)
    {
        $pageModel = config('mm-pages.page_model', Page::class);
        $page = $pageModel::query()
            ->withNotPublished()
            ->withArchived()
            ->withTrashed()
            ->findOrFail($pageId);

        $blocks = $page->blocks()
            ->withExpired()
            ->withNotPublished()
            ->withHidden()
            ->get();

        return [
            'data' => $blocks,
        ];
    }

    public function children($pageBlockId)
    {
        $pageBlockModel = config('mm-pages.page_block_model', PageBlock::class);
        $pageBlock = $pageBlockModel::query()
            ->withNotPublished()
            ->withExpired()
            ->withHidden()
            ->withTrashed()
            ->with(['children'])
            ->findOrFail($pageBlockId);

        return [
            'data' => $pageBlock->children,
        ];
    }
}
