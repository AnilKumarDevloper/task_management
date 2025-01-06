<?php

use App\Http\Controllers\Backend\ApiController;
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
Route::middleware('auth:sanctum')->group(function(){
});

Route::controller(ApiController::class)->group(function(){ 
    Route::get('/get-client-list', 'getClientList')->name('api.get_client_list');
    Route::get('/get-year-folder-list', 'getYearFolderList')->name('api.get_year_folder_list');
    Route::get('/get-month-folder-list', 'getMonthFolderList')->name('api.get_month_folder_list');
    Route::get('/get_document_list', 'getDocumentList')->name('api.get_document_list');
    Route::get('/get-employee', 'getEmployee')->name('api.get_employee');
});

