<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Inventory\Controllers\InventoryController;

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

Route::prefix('/api')->name('api.')->group(function () {

    Route::prefix('/inventory')->name('inventory.')->group(function () {

        Route::controller(InventoryController::class)->group(function () {
            Route::post('/check', 'check')->name('check');
        });
    });

});
