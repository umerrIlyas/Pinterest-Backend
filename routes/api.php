<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', AuthController::class);

Route::apiResource('posts', PostController::class);
Route::get('posts/image/{name}', [PostController::class, 'imagePreview']);

Route::middleware('auth:sanctum')->group(function ($router) {
    $router->get('/user', function (Request $request) {
        return $request->user();
    });

    $router->controller(PostController::class)->group(function ($router) {
        $router->get('/favorites', 'favorites');
    });
});
