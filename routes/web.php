<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\invitationController;
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
//* Dashboard
Route::get('/dashboard',[dashboardController::class,'index'])->middleware(['auth'])->name('dashboard'); 

//*events
Route::resource('event',eventController::class)->middleware(['auth']);
Route::get('event/search',[eventController::class,'search'])->middleware(['auth'])->name('event.search');

//*invitation
Route::get('invitation',[invitationController::class,'create'])->middleware(['auth'])->name('invitation.create');
Route::post('invitation',[invitationController::class,'store'])->middleware(['auth'])->name('invitation.store');

//*mailer
Route::get('Invite',[mailController::class,'send'])->middleware(['auth'])->name('Invite.index');
require __DIR__.'/auth.php';
