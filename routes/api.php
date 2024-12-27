<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//      SELLER ENDPOINT
Route::post('/seller/register', [AuthController::class, 'RegisterSeller']);
Route::post('/seller/category', [CategoryController::class, 'store'])->middleware('auth:sanctum');  
Route::get('/seller/categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');  
Route::apiResource('/seller/products',ProductController::class)->middleware('auth:sanctum');
Route::post('/seller/products/{id}', [ProductController::class, 'update'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'Login']);
Route::post('/logout', [AuthController::class, 'Logout'])->middleware('auth:sanctum');


//      BUYER ENDPOINT
Route::post('/buyer/register', [AuthController::class, 'RegisterBuyer']);
