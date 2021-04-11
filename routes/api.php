<?php

use Illuminate\Support\Facades\Route;
use LambdaDigamma\MMPages\Http\Controllers\API\PageController;

Route::group([
    'prefix' => 'v1/',
    'as' => 'v1.'
], function () {

    Route::apiResource('pages', PageController::class)->except(['index', 'store', 'update', 'destroy']);

});
