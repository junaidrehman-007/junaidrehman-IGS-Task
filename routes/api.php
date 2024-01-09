<?php

use App\Http\Controllers\ProductController;
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

Route::get('/products',[ProductController::class, 'index']);
Route::get('/products/{id}',[ProductController::class, 'show']);
Route::post('/products',[ProductController::class, 'store']);
Route::post('/products/{id}',[ProductController::class, 'update']);
Route::delete('/products/{id}',[ProductController::class, 'destroy']);

// Route::get('/products/sorted', [ProductController::class, 'sorted']);
Route::get('/sorted/products',[ProductController::class, 'sorted']);


Route::group(['middleware' => 'auth:sanctum'], function () {
 
});
