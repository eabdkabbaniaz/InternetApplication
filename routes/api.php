<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\File\FileController as filecontrollergruop;
use App\Http\Controllers\Group\UserGroupController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Profile\ProfileUserController;
use App\Http\Controllers\UserController;
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
Route::group(['prefix' => 'User'], function () {
    Route::post('store', [UserController::class, 'store']);
    Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
    Route::get('/index', [UserController::class, 'index']);
    Route::patch('/update/{id}', [UserController::class, 'update']);
});
Route::group(['prefix' => 'Auth'], function () {
    Route::post('Register', [LoginController::class, 'Register']);
    Route::post('updateFileInGroup', [filecontrollergruop::class, 'updateFileInGroup'])->middleware(['auth:sanctum']);

    Route::post('login', [LoginController::class, 'login']);
});

Route::group(['prefix' => 'Group'], function () {
    Route::post('store', [GroupController::class, 'store'])->middleware(['auth:sanctum']);
    Route::delete('destroy/{id}', [GroupController::class, 'destroy']);
    Route::patch('/update/{id}', [GroupController::class, 'update']);
    Route::get('/index', [GroupController::class, 'index']);
    Route::get('/showAllFiles/{id}', [GroupController::class, 'showAllFiles']);
});

Route::group(['prefix' => 'File', 'middleware' => ['auth:sanctum']], function () {
    Route::post('store', [filecontrollergruop::class, 'store']);
    Route::delete('destroy/{id}/{groupId}', [filecontrollergruop::class, 'destroy'])
    ->middleware('check.group.admin');
    Route::patch('deActiveStatus/{id}', [filecontrollergruop::class, 'deActiveStatus']);
});
Route::group(['prefix' => 'Booking'], function () {
    Route::post('store', [BookingController::class, 'store'])->middleware(['auth:sanctum']);
});

Route::group(['prefix' => 'Profile'], function () {
    Route::get('showProfile', [ProfileUserController::class, 'showProfile'])->middleware(['auth:sanctum']);
});
Route::group(['prefix' => 'GroupUser'], function () {
    Route::post('store', [UserGroupController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('show', [UserGroupController::class, 'show'])->middleware(['auth:sanctum']);
    Route::get('getRoleUser/{groupID}', [UserGroupController::class, 'getRoleUser'])->middleware(['auth:sanctum']);

});

