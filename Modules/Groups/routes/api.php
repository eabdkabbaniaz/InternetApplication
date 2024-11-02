<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Groups\Http\Controllers\GroupsController;

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




Route::group(['prefix' => 'group'], function () {
    Route::post('store', [GroupsController::class, 'store'])->middleware(['auth:sanctum']);
    Route::delete('destroy/{id}', [GroupsController::class, 'destroy']);
    Route::patch('update/{id}', [GroupsController::class, 'update']);
    Route::get('index', [GroupsController::class, 'index']);
    Route::get('showAllFiles/{id}', [GroupsController::class, 'showAllFiles']);
});