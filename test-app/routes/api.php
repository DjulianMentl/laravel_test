<?php

use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\UserController;
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

Route::apiResource('users', UserController::class)->only(['store', 'update', 'show']);
Route::apiResource('groups', GroupController::class)->only(['store', 'update', 'show']);
Route::post('groups/{group}/add-user/{user}', [GroupController::class, 'addUserToGroup']);
