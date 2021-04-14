<?php

use Illuminate\Support\Facades\Route;
use LambdaDigamma\MMPages\Http\Controllers\Admin\BlockVisibilityController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\PageActionsController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\PageBlocksController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\PageBlocksOrderController;

Route::post('/pages/{anypage}/blocks', [PageBlocksController::class, 'store'])->name('pages.blocks.store');
Route::post('/pages/{anypage}/blocks/order', [PageBlocksOrderController::class, 'update'])->name('pages.blocks.order');

Route::post('/blocks/{anyblock}/show', [BlockVisibilityController::class, 'showBlock'])->name('blocks.show');
Route::post('/blocks/{anyblock}/hide', [BlockVisibilityController::class, 'hideBlock'])->name('blocks.hide');

Route::post('/pages/{anypage}/publish', [PageActionsController::class, 'publish'])->name('pages.publish');
Route::post('/pages/{anypage}/unpublish', [PageActionsController::class, 'unpublish'])->name('pages.unpublish');

Route::post('/pages/{anypage}/archive', [PageActionsController::class, 'archive'])->name('pages.archive');
Route::post('/pages/{anypage}/unarchive', [PageActionsController::class, 'unarchive'])->name('pages.unarchive');
