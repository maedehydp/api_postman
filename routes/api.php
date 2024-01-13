<?php

use App\Http\Controllers\AuthController;
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

Route::post('auth/register', [AuthController::class, 'createUser']);
Route::post('auth/logout/{id}', [AuthController::class, 'logoutUser'])->name('logout');
Route::post('auth/login', [AuthController::class, 'loginUser'])->name('login');

//Route::delete('/user/admin-delete/{id}', [AuthController::class, 'destroy'])->middleware(['auth:sanctum', 'permission:admin.delete']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/index', [AuthController::class, 'index']);
    Route::post('/user/delete/{id}', [AuthController::class, 'destroy'])->middleware(['auth:sanctum','permission:admin.delete']);
    Route::post('/user/update/{id}', [AuthController::class, 'update']);
    Route::get('/user/{user}/show', [AuthController::class, 'show']);

});

