<?php

use App\Events\FolderEvent;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/active', function () {
    
//  return   event(new   FolderEvent('hello world'));
  
    $userId = 1; // معرف المستخدم

    $fileId = 12; // معرف الملف

    // استرجاع جميع الأنشطة المتعلقة بالملف (مثل من قام بتعديله أو إضافته)
return  $activities = \Spatie\Activitylog\Models\Activity::
        where('subject_id', 22)  // يحدد النشاطات المرتبطة بالملف (عن طريق معرفه)
        ->get();});
