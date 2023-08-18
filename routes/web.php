<?php

use App\Http\Controllers\CRUD\LeadController;
use App\Http\Controllers\CRUD\UserController;
use App\Http\Controllers\Dashboard\AccountDashboardController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\ClientDashboardController;
use App\Http\Controllers\Dashboard\EmployeeDashboardController;
use App\Http\Controllers\Dashboard\HrDashboardController;
use App\Http\Controllers\Dashboard\ManagerDashboardController;
use App\Http\Controllers\Dashboard\SupervisorDashboardController;
use App\Http\Controllers\Dashboard\VendorDashboardController;
use App\Http\Controllers\Fields\ContactLanguageController;
use App\Http\Controllers\Fields\ContactMethodController;
use App\Http\Controllers\Fields\LeadSourceController;
use App\Http\Controllers\Fields\LeadStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::group(['middleware' => 'role:admin', 'prefix' => 'admin'], function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class);
    Route::resource('lead-sources', LeadSourceController::class);
    Route::resource('lead-statuses', LeadStatusController::class);
    Route::resource('contact-methods', ContactMethodController::class);
    Route::resource('contact-languages', ContactLanguageController::class);
    Route::resource('leads', LeadController::class);
});

Route::group(['middleware' => 'role:manager', 'prefix' => 'manager'], function () {
    Route::get('/', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
});

Route::group(['middleware' => 'role:supervisor', 'prefix' => 'supervisor'], function () {
    Route::get('/', [SupervisorDashboardController::class, 'index'])->name('supervisor.dashboard');
});

Route::group(['middleware' => 'role:accounts', 'prefix' => 'accounts'], function () {
    Route::get('/', [AccountDashboardController::class, 'index'])->name('accounts.dashboard');
});

Route::group(['middleware' => 'role:hr', 'prefix' => 'hr'], function () {
    Route::get('/', [HrDashboardController::class, 'index'])->name('hr.dashboard');
});

Route::group(['middleware' => 'role:employee', 'prefix' => 'employee'], function () {
    Route::get('/', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
});

Route::group(['middleware' => 'role:vendor', 'prefix' => 'vendor'], function () {
    Route::get('/', [VendorDashboardController::class, 'indexr'])->name('vendor.dashboard');
});

Route::group(['middleware' => 'role:client', 'prefix' => 'client'], function () {
    Route::get('/', [ClientDashboardController::class, 'index'])->name('client.dashboard');
});
