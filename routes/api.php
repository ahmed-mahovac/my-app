<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/products/{id}/newestVariant', [ProductController::class, 'showWithNewestVariant']);

Route::get('/productTypes', [ProductTypeController::class, 'index']);

Route::delete('/productTypes/{id}', [ProductTypeController::class, 'destroy']);

Route::put('/productTypes/{id}', [ProductTypeController::class, 'update']);