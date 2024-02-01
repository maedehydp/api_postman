<?php

use App\Events\order_create;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\factorController;
use App\Http\Controllers\mailcontroller;
use App\Http\Controllers\OrderController;
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
Route::get('/event' , function (){

    event(new order_create($orders));
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', [AuthController::class, 'test']);

Route::post('auth/register', [AuthController::class, 'createUser']);
Route::post('auth/logout/{id}', [AuthController::class, 'logoutUser'])->name('logout');
Route::post('auth/login', [AuthController::class, 'loginUser'])->name('login');

//Route::delete('/user/admin-delete/{id}', [AuthController::class, 'destroy'])->middleware(['auth:sanctum', 'permission:admin.delete']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/index', [AuthController::class, 'index'])->middleware('permission:user_index');
    Route::post('/user/delete/{id}', [AuthController::class, 'destroy'])->middleware('permission:user_destroy');
    Route::post('/user/update/{id}', [AuthController::class, 'update'])->middleware('permission:user_update');
//    Route::get('/user/{user}/show', [AuthController::class, 'store'])->middleware('permission:user_index');
    Route::post('/user/{user}/image', [AuthController::class, 'addimage']);
    Route::post('/user/email', [mailcontroller::class, 'mail']);

});


Route::get('/products', [ProductController::class, 'index'])->middleware('permission:product_index');
Route::post('/products/filter', [ProductController::class, 'filter'])->middleware('permission:product_filter');
Route::post('/products/store', [ProductController::class, 'store'])->middleware('permission:product_store');
Route::post('/products/update/{id}', [ProductController::class, 'update'])->middleware('auth:sanctum', 'permission:product_update');
Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->middleware('permission:product_destroy');


Route::get('/orders', [OrderController::class, 'index'])->middleware('auth:sanctum', 'permission:order_index');
Route::post('/orders/filter', [OrderController::class, 'filter'])->middleware('auth:sanctum','permission:order_filter');
Route::post('/orders/store', [OrderController::class, 'store'])->middleware('auth:sanctum', 'permission:order_store');
Route::post('/orders/update/{id}', [OrderController::class, 'update'])->middleware('auth:sanctum', 'permission:order_update');
Route::delete('/orders/delete/{id}', [OrderController::class, 'destroy'])->middleware('auth:sanctum', 'permission:order_destroy');


//factors//
Route::get('/factors', [factorController::class, 'index'])->middleware('auth:sanctum', 'permission:factor_index');
Route::post('/factors/store', [factorController::class, 'store'])->middleware('auth:sanctum', 'permission:factor_store');
Route::delete('/factors/destroy/{id}', [factorController::class, 'destroy'])->middleware('auth:sanctum', 'permission:factor_destroy');
Route::post('/factors/update_status/{id}', [factorController::class, 'update_status'])->middleware('auth:sanctum', 'permission:factor_status');


