<?php

use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'categories' => CategoriesController::class,
    'products' => ProductsController::class,
]);



Route::post('access/tokens', [AccessTokensController::class, 'store']);
Route::delete('access/tokens/{token?}', [AccessTokensController::class, 'destroy'])
    ->middleware('auth:sanctum');
