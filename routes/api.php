<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
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

// ? PUBLIC ROUTES
Route::post('admin/login', [AdminController::class, 'login']);
Route::post('admin/register', [AdminController::class, 'register']);

Route::post('user/login', [UserController::class, 'login']);
Route::post('user/register', [UserController::class, 'register']);

Route::get('tikets', [TiketController::class, 'index']);
Route::get('tikets/{id}', [TiketController::class, 'show']);

// ? PROTECTED ROUTES
Route::middleware('auth:sanctum')->group(function(){
    Route::resource('tikets', TiketController::class)->except([
        'index', 'show'
    ]);
    Route::resource('transaksis', TransaksiController::class);
    Route::post('admin/logout', [AdminController::class, 'logout']);
    Route::post('user/logout', [UserController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
