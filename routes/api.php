<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AccountMastersController;
use App\Http\Controllers\API\AccountLinksController;
use App\Http\Controllers\API\BillsController;

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
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('logout', [UserController::class, 'logout']);

// ACCOUNT MASTER
Route::get('get-account-by-account-master', [AccountMastersController::class, 'getAccountByAccountNumber']);

// ACCOUNT LINKS
Route::get('get-linked-accounts', [AccountLinksController::class, 'getLinkedAccounts']);
Route::post('link-account', [AccountLinksController::class, 'linkAccount']);
Route::get('remove-link', [AccountLinksController::class, 'removeLink']);

// TOKEN
Route::post('insert-token', [UserController::class, 'insertToken']);

// BILLS
Route::get('get-latest-bills', [BillsController::class, 'getLatestBills']);
Route::get('get-unpaid-bills', [BillsController::class, 'getUnpaidBills']);
Route::get('get-bill-details', [BillsController::class, 'getBillDetails']);
Route::get('get-account-information', [BillsController::class, 'getAccountInformation']);
Route::get('get-previous-for-graph', [BillsController::class, 'getPreviousForGraph']);


Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', [UserController::class, 'details']);
});
