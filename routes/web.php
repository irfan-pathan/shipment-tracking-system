<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
Route::get('/shipments/{id}', [ShipmentController::class, 'detail'])->name('shipments.detail');
Route::post('/shipments/store', [ShipmentController::class, 'store'])->name('shipments.store');
Route::post('/shipments/{id}/status', [ShipmentController::class, 'updateStatus'])->name('shipments.updateStatus');
