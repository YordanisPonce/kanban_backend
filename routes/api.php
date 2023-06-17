<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;
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


Route::controller(AuthController::class)->prefix('user')->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});

Route::controller(BoardController::class)->prefix('boards')->group(function () {
    Route::get('/', 'index');
    Route::post('store', 'store');
    Route::delete('delete/{id}', 'destroy');
});


Route::controller(TaskController::class)->prefix('task')->group(function () {
    Route::get('/{boardId}', 'index');
    Route::post('store', 'store');
    Route::delete('delete/{id}', 'destroy');
});
