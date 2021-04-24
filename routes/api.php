<?php

use Illuminate\Support\Facades\Route;
use LambdaDigamma\MMPages\Http\Controllers\API\AdminPageBlocksController;
use LambdaDigamma\MMPages\Http\Controllers\API\PageController;

Route::group([
    'prefix' => 'v1/',
    'as' => 'v1.'
], function () {

    Route::apiResource('pages', PageController::class)->except(['index', 'store', 'update', 'destroy']);

});

Route::group([
    'prefix' => 'v1/admin/',
    'as' => 'v1.',
    'middleware' => config('mm-pages.admin_middleware_stateless', ['api', 'api:auth'])
], function () {

    Route::get('pages/{pageId}/blocks', [AdminPageBlocksController::class, 'index'])
        ->name('admin.page.blocks.index');

});