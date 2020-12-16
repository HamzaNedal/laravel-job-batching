<?php

use App\Http\Controllers\SalesController;
use App\Models\Sales;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/upload',[SalesController::class,'index']);
Route::post('/upload',[SalesController::class,'upload'])->name('upload');
Route::get('/store',[SalesController::class,'store'])->name('store');
Route::get('/batch/{batchId}',[SalesController::class,'batch'])->name('batch');
