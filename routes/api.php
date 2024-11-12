<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AccountMastersController;
use App\Http\Controllers\API\AccountLinksController;
use App\Http\Controllers\API\BillsController;
use App\Http\Controllers\API\NotifiersController;
use App\Http\Controllers\API\VerificationController;
use App\Http\Controllers\API\ThirdPartyAPI;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// LOGIN AND REGISTER
Route::get('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('logout', [UserController::class, 'logout']);
Route::post('reset-password', [UserController::class, 'resetPassword']);

// ACCOUNT MASTER
Route::get('get-account-by-account-master', [AccountMastersController::class, 'getAccountByAccountNumber']);
Route::post('update-contact-info', [AccountMastersController::class, 'updateContactInfo']);

// ACCOUNT LINKS
Route::get('get-linked-accounts', [AccountLinksController::class, 'getLinkedAccounts']);
Route::post('link-account', [AccountLinksController::class, 'linkAccount']);
Route::get('remove-link', [AccountLinksController::class, 'removeLink']);
Route::get('get-pending-accounts', [AccountLinksController::class, 'getPendingAccounts']);

// TOKEN
Route::post('insert-token', [UserController::class, 'insertToken']);

// BILLS
Route::get('get-latest-bills', [BillsController::class, 'getLatestBills']);
Route::get('get-unpaid-bills', [BillsController::class, 'getUnpaidBills']);
Route::get('get-bill-details', [BillsController::class, 'getBillDetails']);
Route::get('get-account-information', [BillsController::class, 'getAccountInformation']);
Route::get('get-previous-for-graph', [BillsController::class, 'getPreviousForGraph']);
Route::get('get-all-bill-by-year', [BillsController::class, 'getAllBillByYear']);

// Notifications
Route::get('get-notifications', [NotifiersController::class, 'getNotifications']);

// VERIFICATION
Route::get('send-sms-test', [VerificationController::class, 'sendSmsTest']);
Route::get('get-email-from-user', [VerificationController::class, 'getEmailFromUser']);


Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', [UserController::class, 'details']);
});

/**
 * THIRD PARTY API
 */
Route::get('get-bill-by-account-and-period', [ThirdPartyAPI::class, 'getBillsByAccountAndPeriod']);
Route::post('transact', [ThirdPartyAPI::class, 'transact']);
Route::post('cancel-transaction', [ThirdPartyAPI::class, 'cancelTransaction']);
