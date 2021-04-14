<?php

namespace LambdaDigamma\MMPages\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Http\Requests\PublishPageRequest;
use LambdaDigamma\MMPages\Models\Page;

class PageActionsController extends Controller
{
    public function archive(Request $request, Page $page)
    {
        $page->archive();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('success', 'Die Seite wurde archiviert.');
    }

    public function unarchive(Request $request, Page $page)
    {
        $page->unArchive();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('success', 'Das Archivieren wurde rückgängig gemacht.');
    }

    public function publish(PublishPageRequest $request, Page $page)
    {
        $published_at = request()->published_at;
        $page->scheduleFor($published_at ? Carbon::parse($published_at) : now());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Veröffentlichungszeitpunkt wurde festgelegt.');
    }

    public function unpublish(Request $request, Page $page)
    {
        $page->unpublish();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('info', 'Die Seite wurde ins Entwurfsstadium zurückversetzt.');
    }
}
