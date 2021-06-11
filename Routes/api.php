<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\CoreModule\Http\Controllers\API\CountryController;
use Modules\CoreModule\Http\Controllers\API\NotificationController;
use Modules\CoreModule\Http\Controllers\API\WalletController;

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

Route::group(['middleware' => ['api','auth','isVerified','isEmailVerified','IsProfileCompleted']], function () {
    //Start Notifications API
    Route::get('user-notifications/{type}/{id}', [NotificationController::class,'getUserNotifications']);
    Route::get('read-notification/{id}',[NotificationController::class,'notificationRead']);
    Route::post('create-notification', [NotificationController::class,'createNotification']);
    //End Notifications API

    //Start Wallets API
    Route::get('user-wallets',[WalletController::class ,'getUserWallets']);
    Route::post('create-wallet',[WalletController::class ,'store']);
    Route::get('wallet-user/{id}',[WalletController::class ,'getWallet']);
    //End Wallets API
});

Route::post('create-firebase-notification',[NotificationController::class,'createFirebaseNotification']);
Route::get('countries', [CountryController::class,'getCountries']);


