<?php

use App\Http\Controllers\campaignController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\invitationController;
use App\Http\Controllers\topManagerController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;


//* Dashboard
Route::get('/dashboard',[dashboardController::class,'index'])->middleware(['auth'])->name('dashboard'); 
Route::any('/settings',[dashboardController::class,'settings'])->middleware(['auth'])->name('settings'); 
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//*events

Route::get('event',[eventController::class, 'index'])->middleware(['auth'])->name('event.index');
Route::any('event/filter',[eventController::class, 'filter'])->middleware(['auth'])->name('event.filter');
Route::any('event/search',[eventController::class,'search'])->middleware(['auth'])->name('event.search');
Route::post('event',[eventController::class, 'store'])->middleware(['auth'])->name('event.store');
Route::get('event/create',[eventController::class, 'create'])->middleware(['auth'])->name('event.create');
Route::get('event/{event}',[eventController::class,'show'])->middleware(['auth'])->name('event.show');
Route::delete('event/{event}',[eventController::class,'destroy'])->middleware(['auth'])->name('event.destroy');


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

//? General stat
Route::any('stats/general',[StatsController::class,'general'])->middleware(["auth"])->name('showFullStack');

require __DIR__.'/auth.php';