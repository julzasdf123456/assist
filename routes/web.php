<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AccountMasterController;
use App\Http\Controllers\AccountLinksController;

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

Route::get('/third_party_transactions/view-transactions/{date}/{co}', [App\Http\Controllers\ThirdPartyTransactionsController::class, 'viewTransactions'])->name('thirdPartyTransactions.view-transactions');
Route::get('/third_party_transactions/post-transactions', [App\Http\Controllers\ThirdPartyTransactionsController::class, 'postTransactions'])->name('thirdPartyTransactions.post-transactions');
Route::resource('thirdPartyTransactions', App\Http\Controllers\ThirdPartyTransactionsController::class);