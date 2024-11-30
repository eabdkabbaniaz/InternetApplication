<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\File\FileController as filecontrollergruop;
use App\Http\Controllers\Group\UserGroupController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Profile\ProfileUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Mail\AccountConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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

//Route::namespace('App\Modules\Groups\Http\Controllers')->group(base_path('app/Modules/Groups/Http/Routes/api.php'));
Route::group(['prefix' => 'Group' , 'middleware'=>['auth:sanctum']], function () {
    Route::post('store', [GroupController::class, 'store'])->middleware(['auth:sanctum']);
    Route::delete('destroy/{groupId}', [GroupController::class, 'destroy'])->middleware('check.group.admin');
    Route::patch('update/{groupId}', [GroupController::class, 'update'])->middleware('check.group.admin');
    Route::get('index', [GroupController::class, 'index']);
    Route::get('showAllFiles/{id}', [GroupController::class, 'showAllFiles']);
});

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
    Route::post('register', [LoginController::class, 'register']);
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('/confirm', [LoginController::class, 'confirmAccount']);


    Route::post('updateFileInGroup', [filecontrollergruop::class, 'updateFileInGroup'])->middleware(['auth:sanctum']);
    Route::post('login', [LoginController::class, 'login']);
});

Route::get('downloadPDF', [ReportController::class, 'downloadPDF']);
Route::get('generatePDF', [ReportController::class, 'generatefilePDF']);
Route::get('generateuserPDF', [ReportController::class, 'generateuserPDF']);
Route::get('DownloadfilePDF', [ReportController::class, 'DownloadfilePDF']);
Route::get('DownloaduserPDF', [ReportController::class, 'DownloaduserPDF']);
Route::get('generatefile', [ReportController::class, 'generatefile']);
Route::get('Downloadfile', [ReportController::class, 'Downloadfile']);



Route::group(['prefix' => 'File', 'middleware' => ['auth:sanctum','logRequest']], function () {
    Route::post('store', [filecontrollergruop::class, 'store']);
    Route::delete('destroy/{id}/{groupId}', [filecontrollergruop::class, 'destroy'])->middleware('check.group.admin');
    Route::delete('destroy/{id}/{groupId}', [filecontrollergruop::class, 'destroy'])
    ->middleware('check.file.delete');
    Route::patch('deActiveStatus/{id}', [filecontrollergruop::class, 'deActiveStatus']);
    Route::patch('/update/{id}', [filecontrollergruop::class, 'update']); //
    Route::post('/deActiveStatusRe', [filecontrollergruop::class, 'deActiveStatusRe']); //
    Route::get('/versions/{id}', [filecontrollergruop::class, 'getVersions']); //
});
Route::group(['prefix' => 'Booking'], function () {
    Route::post('store', [BookingController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/cancelBooking', [BookingController::class, 'cancelBooking'])->middleware(['auth:sanctum']); //
    Route::get('showFile/groupId/{id}', [BookingController::class, 'showFile'])->middleware(['auth:sanctum']);

});

Route::group(['prefix' => 'Profile'], function () {
    Route::get('showProfile', [ProfileUserController::class, 'showProfile'])->middleware(['auth:sanctum']);
    Route::get('showFile/groupId/{id}', [ProfileUserController::class, 'showFile'])->middleware(['auth:sanctum']);
});
Route::group(['prefix' => 'GroupUser','middleware' => ['cors', 'auth:sanctum']], function () {
    Route::post('store', [UserGroupController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('show', [UserGroupController::class, 'show'])->middleware(['auth:sanctum']);
    Route::get('getRoleUser/{groupID}', [UserGroupController::class, 'getRoleUser'])->middleware(['auth:sanctum']);
    Route::delete('/groupId/{groupId}/userId/{userId}', [UserGroupController::class, 'removeUser'])->middleware('check.group.admin');
    Route::get('getUserByGroupId/groupId/{groupId}', [UserGroupController::class, 'getUserByGroupId'])->middleware(['auth:sanctum']);
    Route::get('getUsersNotInGroup/groupId/{groupId}', [UserGroupController::class, 'getUsersNotInGroup'])->middleware(['auth:sanctum']);
});

// في ملف Routes/api.php
// في ملف Routes/api.php




