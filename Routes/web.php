<?php
use Illuminate\Support\Facades\Route;
use Modules\CoreModule\Entities\ExchangeRate;
use Modules\CoreModule\Http\Controllers\ExchangeRateController;
use Modules\CoreModule\Http\Controllers\Fee\DepositFeeController;
use Modules\CoreModule\Http\Controllers\Fee\FeeController;
use Modules\CoreModule\Http\Controllers\Fee\WithdrawFeeController;

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
Route::group(['middleware' => ['auth','isAdmin']], function() {

    Route::name('admin.')->prefix('fees')->group(function () {
        Route::get('/',[FeeController::class,'index'])->name('fees');
        Route::get('/store',[FeeController::class,'store']);
        Route::get('/edit/{id}',[FeeController::class,'edit']);
        Route::any('/update/{id}',[FeeController::class,'update'])->name('fees.update');
        Route::get('/destroy/{id}',[FeeController::class,'destroy'])->name('fees.destroy');
    });

    Route::name('admin.deposit.')->prefix('deposit')->group(function () {
        Route::get('/fees',[DepositFeeController::class,'index'])->name('fees');
        Route::POST('/fees/store',[DepositFeeController::class,'store'])->name('fees.store');
        Route::get('/fees/edit/{id}',[DepositFeeController::class,'edit'])->name('fees.edit');
        Route::any('/fees/update/{id}',[DepositFeeController::class,'update'])->name('fees.update');
        Route::get('/fees/destroy/{id}',[DepositFeeController::class,'destroy'])->name('fees.destroy');
    });
    Route::name('admin.withdraw.')->prefix('withdraw')->group(function () {
        Route::get('/fees',[WithdrawFeeController::class,'index'])->name('fees');
        Route::POST('/fees/store',[WithdrawFeeController::class,'store'])->name('fees.store');
        Route::get('/fees/edit/{id}',[WithdrawFeeController::class,'edit'])->name('fees.edit');
        Route::any('/fees/update/{id}',[WithdrawFeeController::class,'update'])->name('fees.update');
        Route::get('/fees/destroy/{id}',[WithdrawFeeController::class,'destroy'])->name('fees.destroy');
    });




    // /* Withdraw Fee */
    // Route::get('/withdraw/fees','BackEnd\WithdrawFeeController@index')->name('admin.withdraw.fees');
    // Route::POST('/withdraw/fees/store','BackEnd\WithdrawFeeController@store')->name('admin.withdraw.fees.store');
    // Route::get('/withdraw/fees/edit/{id}','BackEnd\WithdrawFeeController@edit')->name('admin.withdraw.fees.edit');
    // Route::any('/withdraw/fees/update/{id}','BackEnd\WithdrawFeeController@update')->name('admin.withdraw.fees.update');
    // Route::get('/withdraw/fees/destroy/{id}','BackEnd\WithdrawFeeController@destroy')->name('admin.withdraw.fees.destroy');



    Route::name('admin.')->prefix('exchange-rates')->group(function () {
        Route::get('/',[ExchangeRateController::class,'index'])->name('exchange.rates');
        Route::get('/store',[ExchangeRateController::class,'store'])->name('exchange.rates.store');
        Route::get('/destroy/{id}',[ExchangeRateController::class,'destroy'])->name('exchange-rates.destroy');
        Route::get('/edit/{id}',[ExchangeRateController::class,'edit'])->name('exchange-rates.edit');
        Route::PATCH('/update/{id}',[ExchangeRateController::class,'update'])->name('exchange-rates.update');
    });
});

