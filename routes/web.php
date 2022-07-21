<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\eventController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard',[dashboardController::class,'index'])->middleware(['auth'])->name('dashboard'); 
Route::resource('event',eventController::class)->middleware(['auth']);
Route::get('event/search',[eventController::class,'search'])->middleware(['auth'])->name('event.search');
require __DIR__.'/auth.php';
