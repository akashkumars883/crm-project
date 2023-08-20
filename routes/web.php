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
use App\Http\Controllers\Fields\BillStatusController;
use App\Http\Controllers\Fields\BillTypeController;
use App\Http\Controllers\Fields\BloodGroupController;
use App\Http\Controllers\Fields\ContactLanguageController;
use App\Http\Controllers\Fields\ContactMethodController;
use App\Http\Controllers\Fields\DepartmentController;
use App\Http\Controllers\Fields\DesignationController;
use App\Http\Controllers\Fields\EmployeeTypeController;
use App\Http\Controllers\Fields\GenderController;
use App\Http\Controllers\Fields\InventoryStatusController;
use App\Http\Controllers\Fields\InventoryTypeController;
use App\Http\Controllers\Fields\InvoiceStatusController;
use App\Http\Controllers\Fields\InvoiceTypeController;
use App\Http\Controllers\Fields\LeadSourceController;
use App\Http\Controllers\Fields\LeadStatusController;
use App\Http\Controllers\Fields\PaymentMethodController;
use App\Http\Controllers\Fields\PaymentStatusController;
use App\Http\Controllers\Fields\ProjectStatusController;
use App\Http\Controllers\Fields\ProjectTypeController;
use App\Http\Controllers\Fields\SkillController;
use App\Http\Controllers\Fields\VendorStatusController;
use App\Http\Controllers\Fields\VendorTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// // Admin Routes
// Route::group(['middleware' => 'role:admin', 'prefix' => 'admin'], function () {
//     Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
// });

Route::resource('leads', LeadController::class);
Route::resource('users', UserController::class);
Route::resource('lead-sources', LeadSourceController::class);
Route::resource('lead-statuses', LeadStatusController::class);
Route::resource('contact-methods', ContactMethodController::class);
Route::resource('contact-languages', ContactLanguageController::class);
Route::resource('bill-statuses', BillStatusController::class);
Route::resource('bill-types', BillTypeController::class);
Route::resource('employee-types', EmployeeTypeController::class);
Route::resource('blood-groups', BloodGroupController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('designations', DesignationController::class);
Route::resource('skills', SkillController::class);
Route::resource('genders', GenderController::class);
Route::resource('invoice-statuses', InvoiceStatusController::class);
Route::resource('invoice-types', InvoiceTypeController::class);
Route::resource('inventory-statuses', InventoryStatusController::class);
Route::resource('inventory-types', InventoryTypeController::class);
Route::resource('payment-methods', PaymentMethodController::class);
Route::resource('payment-statuses', PaymentStatusController::class);
Route::resource('project-types', ProjectTypeController::class);
Route::resource('project-statuses', ProjectStatusController::class);
Route::resource('vendor-statuses', VendorStatusController::class);
Route::resource('vendor-types', VendorTypeController::class);