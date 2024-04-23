<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // New 
use App\http\Controllers\StoreController; // Store
use App\http\Controllers\TranSectionController;
use App\http\Controllers\Billcontroller;
use App\Http\Controllers\ReportController; // Report

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::post('register' , [UserController::class,'register']);
Route::post('login' , [UserController::class,'login']);
Route::get('logout' , [UserController::class,'logout']);


Route::controller(StoreController::class)->group(function(){
        Route::get('store' , 'index');
        Route::get('store/edit/{id}' , 'edit');
        Route::post('store/add' , 'add');
        Route::post('store/update/{id}' , 'update');
        Route::delete('store/delete/{id}' , 'delete');

});

Route::controller(TranSectionController::class)->group(function(){
    Route::post('transection' , 'index');
    // Route::get('TranSectionController/edit/{id}' , 'edit');
    Route::post('transection/add' , 'add');
   /*  Route::post('TranSectionController/update/{id}' , 'update');
    Route::delete('TranSectionController/delete/{id}' , 'delete');
 */
});



Route::controller(Billcontroller::class)->group(function(){
  /*   Route::get('TranSectionController' , 'index');
    Route::get('TranSectionController/edit/{id}' , 'edit'); */
    Route::get('bills/print/{id}' , 'print_bill');
   /*  Route::post('TranSectionController/update/{id}' , 'update');
    Route::delete('TranSectionController/delete/{id}' , 'delete');
 */
});



Route::controller(ReportController::class)->group(function(){
   Route::post('report' , 'created_report');

});

