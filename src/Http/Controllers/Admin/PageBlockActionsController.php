<?php

namespace LambdaDigamma\MMPages\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Http\Requests\PublishPageBlockRequest;
use LambdaDigamma\MMPages\Models\PageBlock;

class PageBlockActionsController extends Controller
{
    
    public function publish(PublishPageBlockRequest $request, PageBlock $pageBlock)
    {
        $published_at = request()->published_at;
        $pageBlock->scheduleFor($published_at ? Carbon::parse($published_at) : now());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Veröffentlichungszeitpunkt wurde festgelegt.');
    }

    public function unpublish(Request $request, PageBlock $pageBlock)
    {
        $pageBlock->unpublish();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('info', 'Dieser Block wurde in den Entwurfsstadium zurückversetzt.');
    }

}