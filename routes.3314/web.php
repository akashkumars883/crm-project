<?php

use App\Http\Controllers\CRUD\ActivityController;
use App\Http\Controllers\CRUD\AttachmentController;
use App\Http\Controllers\CRUD\AttendanceRecordController;
use App\Http\Controllers\CRUD\BillController;
use App\Http\Controllers\CRUD\CustomerController;
use App\Http\Controllers\CRUD\EmployeeBankAccountController;
use App\Http\Controllers\CRUD\EmployeeController;
use App\Http\Controllers\CRUD\EmployeeUserController;
use App\Http\Controllers\CRUD\InventoryController;
use App\Http\Controllers\CRUD\InvoiceController;
use App\Http\Controllers\CRUD\LeadController;
use App\Http\Controllers\CRUD\PaymentController;
use App\Http\Controllers\CRUD\ProjectController;
use App\Http\Controllers\CRUD\TicketController;
use App\Http\Controllers\CRUD\UserController;
use App\Http\Controllers\CRUD\VendorController;
use App\Http\Controllers\CRUD\VendorUserController;
use App\Http\Controllers\Fields\ActivityTypeController;
use App\Http\Controllers\Fields\AttachmentTypeController;
use App\Http\Controllers\Fields\AttendanceStatusController;
use App\Http\Controllers\Fields\AttendanceTypeController;
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
use App\Http\Controllers\Fields\TicketCategoryController;
use App\Http\Controllers\Fields\VendorStatusController;
use App\Http\Controllers\Fields\VendorTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// // Admin Routes
// Route::group(['middleware' => 'role:admin', 'prefix' => 'admin'], function () {
//     Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
// });

Route::resource('leads', LeadController::class);
Route::resource('users', UserController::class);
// Route::get('users/export/', [UsersController::class, 'export'])->name('users.export');
Route::resource('invoices', InvoiceController::class);
Route::resource('customers', CustomerController::class);
Route::resource('projects', ProjectController::class);
Route::resource('activities', ActivityController::class);
Route::resource('employee-bank-accounts', EmployeeBankAccountController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('employee-users', EmployeeUserController::class);
Route::resource('vendors', VendorController::class);
Route::resource('vendor-users', VendorUserController::class);
Route::resource('tickets', TicketController::class);
Route::resource('inventories', InventoryController::class);
Route::resource('attendance-records', AttendanceRecordController::class);
Route::resource('attachments', AttachmentController::class);
Route::resource('payments', PaymentController::class);
Route::resource('bills', BillController::class);

Route::resource('attendance-types', AttendanceTypeController::class);
Route::resource('attendance-statuses', AttendanceStatusController::class);
Route::resource('activity-types', ActivityTypeController::class);
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
Route::resource('ticket-categories', TicketCategoryController::class);
Route::resource('attachment-types', AttachmentTypeController::class);

// Laratrust routes
// Route::group(['middleware' => ['auth', 'role:admin']], function () {
//     Route::resource('/permissions', 'PermissionsController', ['as' => 'laratrust'])
//         ->only(['index', 'create', 'store', 'edit', 'update']);

//     Route::resource('/roles', 'RolesController', ['as' => 'laratrust']);

//     Route::resource('/roles-assignment', 'RolesAssignmentController', ['as' => 'laratrust'])
//         ->only(['index', 'edit', 'update']);
// });

// Client Routes
Route::get('/my-invoices', [CustomerController::class, 'myInvoices'])->name('myInvoices');
Route::get('/my-projects', [CustomerController::class, 'myProjects'])->name('myProjects');
Route::get('/my-payments', [CustomerController::class, 'myPayments'])->name('myPayments');
Route::get('/my-tickets', [CustomerController::class, 'myTickets'])->name('myTickets');

// Vendor Routes
Route::get('/v-bills', [VendorUserController::class, 'vBills'])->name('vBills');
Route::get('/v-inventories', [VendorUserController::class, 'vInventories'])->name('vInventories');

// Employee Routes
Route::get('/my-attendance', [EmployeeController::class, 'myAttendance'])->name('myAttendance');
Route::get('/emp-bills', [EmployeeController::class, 'empBills'])->name('empBills');
Route::get('/my-bank-accounts', [EmployeeController::class, 'myBank'])->name('myBank');
// Route::get('/emp-projects', [EmployeeController::class, 'empProjects'])->name('empProjects');
Route::get('/emp-profile', [EmployeeController::class, 'empProfile'])->name('empProfile');
