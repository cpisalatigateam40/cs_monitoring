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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.page');
Route::get('/input', [InputController::class, 'index'])->name('input.index');
Route::get('/rekap-gudang', [WarehouseRecapController::class, 'index'])->name('warehouse.recap');
Route::get('/rekap-pengiriman', [ShipmentRecapController::class, 'index'])
    ->name('shipment.recap');
    
Route::get('/master/warehouse', [WarehouseController::class, 'index'])
    ->name('master.warehouse');
Route::get('/master/expedition', [ExpeditionController::class, 'index'])
    ->name('master.expedition');
Route::get('/master/employee', [EmployeeController::class, 'index'])
    ->name('master.employee');
Route::get('/master/plant', [PlantController::class, 'index'])
    ->name('master.plant');