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
use App\Http\Controllers\DepartmentController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.page');
    Route::get('/input', [InputController::class, 'index'])->name('input.index');
    Route::get('/rekap-gudang', [WarehouseRecapController::class, 'index'])->name('warehouse.recap');
    Route::get('/rekap-pengiriman', [ShipmentRecapController::class, 'index'])
        ->name('shipment.recap');
    Route::post('/input/warehouse/store', [InputController::class, 'warehouseStore'])->name('warehouse-temperature.store');
    Route::post('/input/delivery/store', [InputController::class, 'deliveryStore'])->name('deliveries.store');
    Route::get('/temperature/template/warehouse', [InputController::class, 'templateWarehouse'])->name('temperature.template.warehouse');
    Route::get('/temperature/template/delivery', [InputController::class, 'templateDelivery'])->name('temperature.template.delivery');
    Route::post('/temperature/import/warehouse', [InputController::class, 'importWarehouse'])->name('import.warehouse');
    Route::post('/temperature/import/delivery', [InputController::class, 'importDelivery'])->name('temperature.import.delivery');

    Route::post('/set-plant', [PlantController::class, 'setPlant'])->name('setPlant');

    Route::resource('warehouses', WarehouseController::class);
    Route::resource('expeditions', ExpeditionController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('plants', PlantController::class);
    Route::resource('departments', DepartmentController::class);
});
