<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\handpohoneControllers;
use App\Http\Controllers\modelhpController;
use App\Http\Controllers\SuplierControllers;

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
Route::get('/search',[handpohoneControllers::class,'search']);

Route::get('admin',function(){
    return view('admin');
})->name('admin')->middleware('admin');
Route::resource('/admin/hpbase', handpohoneControllers::class);
Route::resource('/admin/mod', modelhpController::class);
Route::resource('/admin/suplai', SuplierControllers::class);


Route::get('kasir',function(){
    return view('kasir');
})->name('kasir')->middleware('kasir');

Route::get('manajer',function(){
    return view('manajer');
})->name('manajer')->middleware('manajer');

Route::get('customer',function(){
    return view('customer');
})->name('customer')->middleware('customer');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
