<?php

namespace LambdaDigamma\MMPages\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Http\Requests\DeletePageRequest;
use LambdaDigamma\MMPages\Models\Page;

class PageController extends Controller
{
    
    public function delete(DeletePageRequest $request, Page $page)
    {
        if ($request->force) {
            $page->forceDelete();
        } else {
            $page->delete();
        }

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Die Seite wurde gelöscht.');
    }

    public function restore(Request $request, Page $page)
    {
        $page->restore();

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Die Seite wurde wiederhergestellt.');
    }

}