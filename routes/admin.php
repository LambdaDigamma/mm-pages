<?php

use Illuminate\Support\Facades\Route;
use LambdaDigamma\MMPages\Http\Controllers\Admin\BlockVisibilityController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\EditorController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\PageActionsController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\PageBlockActionsController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\PageBlocksController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\PageBlockSlotOrderController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\PageBlocksOrderController;
use LambdaDigamma\MMPages\Http\Controllers\Admin\PageController;

Route::post('/pages/{anypage}/blocks', [PageBlocksController::class, 'store'])->name('pages.blocks.store');
Route::post('/pages/{anypage}/blocks/order', [PageBlocksOrderController::class, 'update'])->name('pages.blocks.order');

Route::post('/blocks/{anyblock}/show', [BlockVisibilityController::class, 'showBlock'])->name('blocks.show');
Route::post('/blocks/{anyblock}/hide', [BlockVisibilityController::class, 'hideBlock'])->name('blocks.hide');

Route::post('/blocks/{anyblock}/publish', [PageBlockActionsController::class, 'publish'])->name('blocks.publish');
Route::post('/blocks/{anyblock}/unpublish', [PageBlockActionsController::class, 'unpublish'])->name('blocks.unpublish');

Route::post('/blocks/{anyblock}/expire', [PageBlockActionsController::class, 'expire'])->name('blocks.expire');
Route::post('/blocks/{anyblock}/unexpire', [PageBlockActionsController::class, 'unexpire'])->name('blocks.unexpire');

Route::delete('/blocks/{anyblock}', [PageBlocksController::class, 'delete'])->name('blocks.delete');
Route::post('/blocks/{anyblock}/restore', [PageBlocksController::class, 'restore'])->name('blocks.restore');

Route::delete('/pages/{anypage}', [PageController::class, 'delete'])->name('pages.delete');
Route::post('/pages/{anypage}/restore', [PageController::class, 'restore'])->name('pages.restore');

Route::post('/pages/{anypage}/publish', [PageActionsController::class, 'publish'])->name('pages.publish');
Route::post('/pages/{anypage}/unpublish', [PageActionsController::class, 'unpublish'])->name('pages.unpublish');

Route::post('/pages/{anypage}/archive', [PageActionsController::class, 'archive'])->name('pages.archive');
Route::post('/pages/{anypage}/unarchive', [PageActionsController::class, 'unarchive'])->name('pages.unarchive');

Route::get('/editor/menu', [EditorController::class, 'menu'])->name('editor.menu.index');

// Slot
Route::post('/page-blocks/{anypageblock}/children/order', [PageBlockSlotOrderController::class, 'update'])->name('page-blocks.children.order');