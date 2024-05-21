<?php

use Illuminate\Support\Facades\Route;
use LambdaDigamma\MMPages\Http\Controllers\API\AdminPageBlocksController;
use LambdaDigamma\MMPages\Http\Controllers\API\PageController;

Route::group([
    'prefix' => 'v1/',
    'as' => 'v1.',
], function () {

    if (! config('mm-pages.api_disable_page_endpoint', false)) {
        Route::get('pages/{id}', [PageController::class, 'show'])
            ->middleware('cache.headers:public;max_age=3600;etag')
            ->name('pages.show');
    }

});

Route::group([
    'prefix' => 'v1/admin/',
    'as' => 'v1.',
    'middleware' => config('mm-pages.admin_middleware_stateless', ['api', 'api:auth']),
], function () {

    Route::get('pages/{pageId}/blocks', [AdminPageBlocksController::class, 'index'])
        ->name('admin.page.blocks.index');

    Route::get('page-blocks/{pageBlockId}/children', [AdminPageBlocksController::class, 'children'])
        ->name('admin.page-blocks.children');

});
