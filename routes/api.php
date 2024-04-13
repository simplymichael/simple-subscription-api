<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\WebsiteController;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

Route::get('/websites', [WebsiteController::class, 'getWebsitesList']);
Route::get('/websites/{id}/posts', [WebsiteController::class, 'getPostsList']);
Route::post('/websites/{id}/posts/new', [PostController::class, 'store']);
Route::post('/websites/{id}/subscribers/new', [WebsiteController::class, 'addSubscriber']);
