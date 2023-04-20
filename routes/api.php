<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Test;
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




Route::get('/test',[Test::class,'index']);
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::get('/admin',[AdminController::class,'index'])->middleware(['auth:sanctum']);
Route::get('/guru',[GuruController::class,'index'])->middleware(['auth:sanctum']);
Route::get('/ortu',[OrtuController::class,'index'])->middleware(['auth:sanctum']);
