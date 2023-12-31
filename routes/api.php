<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CatalogController;
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

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->get('/catalog', [CatalogController::class, 'index']);
Route::middleware('auth:sanctum')->post('/tokens/create', [AuthController::class, 'createAdditionalToken']);
Route::middleware('auth:sanctum')->post('/tokens/expire', [AuthController::class, 'expireToken']);
Route::middleware('auth:sanctum')->post('/tokens/expire-all', [AuthController::class, 'expireAllTokens']);
