<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AccountMasterController;
use App\Http\Controllers\AccountLinksController;
use App\Http\Controllers\ThirdPartyTransactionsController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Account Links
Route::get('/account_links/approve-account-link/{id}', [AccountLinksController::class, 'approveAccountLink'])->name('accountLinks.approve-account-link');
Route::get('/account_links/reject-account-link/{id}', [AccountLinksController::class, 'rejectAccountLink'])->name('accountLinks.reject-account-link');

Route::resource('users', UsersController::class);
Route::resource('accountMasters', AccountMasterController::class);


Route::resource('accountMasters', App\Http\Controllers\AccountMasterController::class);

Route::resource('accountLinks', App\Http\Controllers\AccountLinksController::class);

Route::resource('tokens', App\Http\Controllers\TokensController::class);

Route::resource('bills', App\Http\Controllers\BillsController::class);

Route::resource('paidBills', App\Http\Controllers\PaidBillsController::class);

Route::resource('userAppLogs', App\Http\Controllers\UserAppLogsController::class);

Route::resource('notifiers', App\Http\Controllers\NotifiersController::class);

Route::get('/third_party_tokens/regenerate-token/{id}', [App\Http\Controllers\ThirdPartyTokensController::class, 'regenerateToken'])->name('thirdPartyTokens.regenerate-token');
Route::resource('thirdPartyTokens', App\Http\Controllers\ThirdPartyTokensController::class);

Route::resource('billsExtensions', App\Http\Controllers\BillsExtensionController::class);

Route::get('/third_party_transactions/view-transactions/{date}/{co}', [ThirdPartyTransactionsController::class, 'viewTransactions'])->name('thirdPartyTransactions.view-transactions');
Route::get('/third_party_transactions/post-transactions', [ThirdPartyTransactionsController::class, 'postTransactions'])->name('thirdPartyTransactions.post-transactions');
Route::get('/third_party_transactions/mark-as-posted', [ThirdPartyTransactionsController::class, 'markAsPosted'])->name('thirdPartyTransactions.mark-as-posted');
Route::get('/third_party_transactions/posted-transactions', [ThirdPartyTransactionsController::class, 'postedTransactions'])->name('thirdPartyTransactions.posted-transactions');
Route::get('/third_party_transactions/view-posted-transactions/{date}/{co}', [ThirdPartyTransactionsController::class, 'viewPostedTransactions'])->name('thirdPartyTransactions.view-posted-transactions');
Route::get('/third_party_transactions/print-double-payments/{date}/{co}', [ThirdPartyTransactionsController::class, 'printDoublePayments'])->name('thirdPartyTransactions.print-double-payments');
Route::get('/third_party_transactions/print-posted-payments/{date}/{co}', [ThirdPartyTransactionsController::class, 'printPostedPayments'])->name('thirdPartyTransactions.print-posted-payments');
Route::get('/third_party_transactions/get-posted-calendar-data', [ThirdPartyTransactionsController::class, 'getPostedCalendarData'])->name('thirdPartyTransactions.get-posted-calendar-data');
Route::get('/third_party_transactions/get-graph-data', [ThirdPartyTransactionsController::class, 'getGraphData'])->name('thirdPartyTransactions.get-graph-data');
Route::get('/third_party_transactions/get-graph-data-yearly', [ThirdPartyTransactionsController::class, 'getGraphDataYearly'])->name('thirdPartyTransactions.get-graph-data-yearly');
Route::resource('thirdPartyTransactions', ThirdPartyTransactionsController::class);