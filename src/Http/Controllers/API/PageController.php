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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return new EventCollection(Event::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $defaultSize = config('json-api-paginate.default_size');
        $sizeParameter = config('json-api-paginate.size_parameter');
        $paginationParameter = config('json-api-paginate.pagination_parameter');

        $size = (int) request()->input($paginationParameter.'.'.$sizeParameter, 10);

        $pageModel = config('mm-pages.page_model');
        // $mediaInstance = new $mediaClass();

        return new PageResource(
            $pageModel::with([
                'blocks',
            ])
            ->findOrFail($id)
        );

        // return new EventResource(Event::with('page', 'place')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
