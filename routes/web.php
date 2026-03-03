<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BeanSproutSaleController;
use App\Http\Controllers\WaterSaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('transactions', TransactionController::class);
Route::resource('bean-sprout-sales', BeanSproutSaleController::class);
Route::resource('water-sales', WaterSaleController::class);

// Settings Route
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
