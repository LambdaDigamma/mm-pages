<?php

namespace LambdaDigamma\MMPages\Http\Controllers\API;

use Illuminate\Http\Request;
use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Http\Resources\Page as PageResource;
use LambdaDigamma\MMPages\Models\Page;

// use LambdaDigamma\MMFeeds\Models\Feed;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(): void
    {
        // return new EventCollection(Event::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     *
     * @return PageResource
     */
    public function show($id): PageResource
    {
        config('json-api-paginate.default_size');
        $sizeParameter = config('json-api-paginate.size_parameter');
        $paginationParameter = config('json-api-paginate.pagination_parameter');

        (int) request()->input($paginationParameter.'.'.$sizeParameter, 10);

        $pageModel = config('mm-pages.page_model', Page::class);
        
        return new PageResource(
            $pageModel::with([
                'blocks',
            ])
            ->findOrFail($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param int  $id
     *
     * @return void
     */
    public function update(Request $request, $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     *
     * @return void
     */
    public function destroy($id): void
    {
        //
    }
}
