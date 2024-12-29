<?php

use App\Events\StatusLiked;
use App\Http\Controllers\ReportController;
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

// Route::get('/', function () {
//     return view('groupReport');
// });
Route::get('uu', function () {
    event(new StatusLiked('wawa'))    ;
});

Route::get('/{filename}')->name('download.file');
// Route::get('dd')->function([
   
// ])->name('dd');




Route::get('/
', function () {
    // echo 12;
//  return   event(new   FolderEvent('hello world'));
  
    // $userId = 1; // معرف المستخدم

    // $fileId = 12; // معرف الملف

    // استرجاع جميع الأنشطة المتعلقة بالملف (مثل من قام بتعديله أو إضافته)
return  $activities = \Spatie\Activitylog\Models\Activity::
        all()->last();})->name('active');

        
        