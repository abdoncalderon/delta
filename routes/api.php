<?php

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

Route::group( ['middleware'=> ["auth:sanctum"]], function() {
    
    //Route::get('/menusRole', [App\Http\Controllers\Settings\MenuRoleController::class,'getMenusRole']);
    // Route::get('/getCurrentProject', [App\Http\Controllers\HomeController::class,'getCurrentProject']);
    

    Route::get('/project/{id}', [App\Http\Controllers\Project\ProjectController::class,'getProject']);
    Route::get('/getFolioNumber/{id}', [App\Http\Controllers\Production\WorkBook\FolioController::class,'getFolioNumber']);
    Route::get('/getFoliosXLocation/{location_id}/{fromDate}/{untilDate}', [App\Http\Controllers\Production\WorkBook\FolioController::class,'getFoliosXLocation']);
    Route::get('/getPositionsDailyReport/{id}', [App\Http\Controllers\Production\WorkBook\PositionDailyReportController::class,'getPositionsDailyReport']);
    Route::get('/getEquipmentsDailyReport/{id}', [App\Http\Controllers\Production\WorkBook\EquipmentDailyReportController::class,'getEquipmentsDailyReport']);
    Route::get('/getEventsDailyReport/{id}', [App\Http\Controllers\Production\WorkBook\EventDailyReportController::class,'getEventsDailyReport']);
    Route::get('/getAttachmentsDailyReport/{id}', [App\Http\Controllers\Production\WorkBook\AttachmentDailyReportController::class,'getAttachmentsDailyReport']);
    Route::get('/getCommentsNote/{id}', [App\Http\Controllers\Production\WorkBook\CommentNoteController::class,'getCommentsNote']);
    Route::get('/getOldDailyReports/{location_id}/{dailyReport_id}', [App\Http\Controllers\Production\WorkBook\DailyReportController::class,'getOldDailyReports']);
});


