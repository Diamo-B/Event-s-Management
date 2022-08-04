<?php

use App\Http\Controllers\campaignController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\invitationController;
use App\Http\Controllers\topManagerController;
use App\Http\Controllers\StatsController;
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

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//*events
Route::resource('event',eventController::class)->middleware(['auth']);
Route::any('event/search',[eventController::class,'search'])->middleware(['auth'])->name('event.search');

//*invitation
Route::get('invitation',[invitationController::class,'create'])->middleware(['auth'])->name('invitation.create');
Route::post('invitation',[invitationController::class,'store'])->middleware(['auth'])->name('invitation.store');
Route::any('invitation/view',[invitationController::class,'index'])->middleware(['auth'])->name('invitation.index');
Route::get('invitation/view/download/{attachment}',[invitationController::class,'download'])->middleware(['auth'])->name('download.attachment');
Route::delete('invitation/view/delete/{id}',[invitationController::class,'delete'])->middleware(['auth'])->name('invitation.delete');


//* campaign
Route::get('campaign/create',[campaignController::class,'create'])->middleware(['auth'])->name('campaign.create');
Route::post('campaign/store',[campaignController::class,'store'])->middleware(['auth'])->name('campaign.store');
Route::any('campaign/view',[campaignController::class, 'index'])->middleware(['auth'])->name('campaign.view'); 
Route::any('campaign/confirm/{eventId}/{campaigns?}',[campaignController::class, 'presenceConfirm'])->middleware(['auth'])->name('presenceConfirm');

//*mailer
Route::get('Invite',[mailController::class,'send'])->middleware(['auth'])->name('Invite.send');

//*Accept invitation
Route::any('/Invite/AcceptInvitation/{token}',[invitationController::class,'AcceptInvite'])->name('AcceptInvite');
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//* TopManager routes
//? data
Route::any('Data/{eventId?}',[topManagerController::class, 'getData'])->middleware(["auth"])->name('realTimeData');
Route::any('History/{eventId?}',[topManagerController::class, 'getData'])->middleware(["auth"])->name('history');
//? stats
Route::any('stats/data',[StatsController::class, 'DataStats'])->middleware(["auth"])->name('DataStats');
Route::any('stats/history',[StatsController::class, 'HistoryStats'])->middleware(["auth"])->name('HistoryStats');
Route::post('stats/{type?}/show',[StatsController::class ,'ShowStats'])->middleware(['auth'])->name('showStats');
require __DIR__.'/auth.php';