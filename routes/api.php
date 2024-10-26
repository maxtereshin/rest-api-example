<?php

use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\User\PostController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::post('/admin/login', 'admin');

    Route::post('password/forgot', 'forgotPassword');
    Route::post('password/reset', 'resetPassword');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::prefix('user')->middleware('roles:user')->group(function () {
        Route::prefix('post')->group(function () {
            Route::get('list', [PostController::class, 'list']);
            Route::post('add', [PostController::class, 'add']);
            Route::get('{id}/get', [PostController::class, 'get'])->whereNumber('id');
            Route::post('{id}/update', [PostController::class, 'update'])->whereNumber('id');
            Route::delete('{id}/delete', [PostController::class, 'delete'])->whereNumber('id');
        });
    });

    Route::prefix('admin')->middleware('roles:admin')->group(function () {
        Route::get('user/list', [UserController::class, 'list']);
    });

});
