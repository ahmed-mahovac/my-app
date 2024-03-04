<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
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


Route::middleware('auth:api')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::middleware('scopes:view-email')->get('/user', function (Request $request) {
        Log::info('user', ['user' => $request->header('Authorization')]);
        return $request->user();
    });

    Route::middleware('restrictRole:admin')->group(function () {

        Route::delete('/productTypes/{id}', [ProductTypeController::class, 'destroy']);

        Route::put('/productTypes/{id}', [ProductTypeController::class, 'update']);

        // products file upload
        
       // Route::post('/products', [ProductController::class, 'upload']);

        // state transitions

        Route::post('/products/{id}/activate', [ProductController::class, 'activateProduct']);

        Route::post('/products/{id}/draft', [ProductController::class, 'draftProduct']);

        Route::post('/products/{id}/delete', [ProductController::class, 'deleteProduct']);

        // state operations

        Route::post('/products/{id}/variants', [ProductController::class, 'addVariant']);

        Route::delete('/products/{productId}/variants/{variantId}', [ProductController::class, 'removeVariant']);

    });
});

// public routes

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/products/{id}/newestVariant', [ProductController::class, 'showWithNewestVariant']);

Route::get('/productTypes', [ProductTypeController::class, 'index']);

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('register', [AuthController::class, 'register']);

Route::post('/products', [ProductController::class, 'upload']);
