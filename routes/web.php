<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\WarehouseRecapController;
use App\Http\Controllers\ShipmentRecapController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ExpeditionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\AuthController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.page');
    Route::get('/input', [InputController::class, 'index'])->name('input.index');
    Route::get('/rekap-gudang', [WarehouseRecapController::class, 'index'])->name('warehouse.recap');
    Route::get('/rekap-pengiriman', [ShipmentRecapController::class, 'index'])
        ->name('shipment.recap');
    Route::post('/input/warehouse/store', [InputController::class, 'warehouseStore'])->name('warehouse-temperature.store');
    Route::post('/input/delivery/store', [InputController::class, 'deliveryStore'])->name('deliveries.store');

    Route::resource('warehouses', WarehouseController::class);
    Route::resource('expeditions', ExpeditionController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('plants', PlantController::class);
});
