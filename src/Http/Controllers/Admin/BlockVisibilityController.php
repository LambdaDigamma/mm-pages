<?php

namespace LambdaDigamma\MMPages\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Http\Requests\HideBlockRequest;
use LambdaDigamma\MMPages\Http\Requests\ShowBlockRequest;
use LambdaDigamma\MMPages\Models\PageBlock;

class BlockVisibilityController extends Controller
{
    /**
     * Resets the `hidden_at` attribute.
     *
     * @param \LambdaDigamma\MMPages\Http\Requests\ShowBlockRequest $request
     * @param \LambdaDigamma\MMPages\Models\PageBlock               $block
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function showBlock(ShowBlockRequest $request, PageBlock $block)
    {
        $block->update(['hidden_at' => null]);

        return $request->wantsJson()
            ? "Test" //;new JsonResponse('', 200)
            : "Test1"; //redirect()->back()->with('success', 'Der Block wurde sichtbar gemacht.');
    }

    /**
     * Sets the `hidden_at` attribute to the current timestamp.
     *
     * @param \LambdaDigamma\MMPages\Http\Requests\HideBlockRequest $request
     * @param \LambdaDigamma\MMPages\Models\PageBlock               $block
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function hideBlock(HideBlockRequest $request, PageBlock $block)
    {
        $block->update(['hidden_at' => now()]);

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Block wurde versteckt.');
    }
}
