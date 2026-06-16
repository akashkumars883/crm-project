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
use App\Http\Controllers\CRUD\MyLeadsController;
use App\Http\Controllers\CRUD\MyProjectsController;
use App\Http\Controllers\CRUD\MyTicketsController;
use App\Http\Controllers\CRUD\PaymentController;
use App\Http\Controllers\CRUD\ProjectController;
use App\Http\Controllers\CRUD\TicketController;
use App\Http\Controllers\CRUD\UserController;
use App\Http\Controllers\CRUD\VendorController;
use App\Http\Controllers\CRUD\VendorUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProjectTaskController;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
// Auth::routes();
Auth::routes(['register' => false]);

// SaaS Registration Routes
Route::get('/register-company', [App\Http\Controllers\CompanyRegistrationController::class, 'showRegistrationForm'])->name('company.register');
Route::post('/register-company', [App\Http\Controllers\CompanyRegistrationController::class, 'register'])->name('company.register.submit');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::get('/fix-role', function () {
    try {
        // Fix any missing user_type in the DB
        \Illuminate\Support\Facades\DB::statement("UPDATE role_user SET user_type = 'App\\\\Models\\\\User' WHERE user_type IS NULL OR user_type = ''");

        $superadmin = \App\Models\User::where('email', 'superadmin@homeglazer.com')->first();
        if ($superadmin && !$superadmin->hasRole('super-admin')) {
            $superadmin->addRole('super-admin');
        }

        $admin = \App\Models\User::where('email', 'admin@homeglazer.com')->first();
        if ($admin && !$admin->hasRole('admin')) {
            $admin->addRole('admin');
        }

        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        
        return 'SUCCESS: Roles have been properly assigned and cache cleared. You can now go to /home';
    } catch (\Throwable $e) {
        return 'ERROR: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine();
    }
});

// // Admin Routes
// Route::group(['middleware' => 'role:admin', 'prefix' => 'admin'], function () {
//     Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
// });

// Profile & Settings Routes
Route::middleware('auth')->group(function () {
    // Admin / CRM Routes
    Route::resource('leads', LeadController::class);
    Route::resource('users', UserController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::post('invoices/{invoice}/convert', [InvoiceController::class, 'convertProforma'])->name('invoices.convert');
    Route::resource('customers', CustomerController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('project-tasks', ProjectTaskController::class)->only(['store', 'update', 'destroy']);
    Route::post('project-tasks/{projectTask}/update-status', [ProjectTaskController::class, 'updateStatus'])->name('project-tasks.update-status');
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
    Route::resource('expenses', ExpenseController::class);

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

    // Manager and Supervisor Routes
    Route::resource('my-tickets', MyTicketsController::class);
    Route::resource('my-projects', MyProjectsController::class);
    Route::resource('my-leads', MyLeadsController::class);

    // Client Routes
    Route::get('/client/my-invoices', [CustomerController::class, 'myInvoices'])->name('myInvoices');
    Route::get('/client/my-invoices/{id}', [CustomerController::class, 'myInvoiceShow'])->name('myInvoiceShow');
    Route::get('/client/my-invoices/{id}/print', [CustomerController::class, 'myInvoicePrint'])->name('myInvoicePrint');
    Route::get('/client/my-projects', [CustomerController::class, 'myProjects'])->name('myProjects');
    Route::get('/client/my-projects/{id}', [CustomerController::class, 'myProjectShow'])->name('myProjectShow');
    Route::get('/client/my-payments', [CustomerController::class, 'myPayments'])->name('myPayments');
    Route::get('/client/my-tickets', [CustomerController::class, 'myTickets'])->name('myTickets');
    Route::get('/client/my-profile', [CustomerController::class, 'myProfile'])->name('myProfile');
    Route::post('/client/my-profile', [CustomerController::class, 'myProfileUpdate'])->name('myProfile.update');
    Route::get('/client/create-ticket', [CustomerController::class, 'createTicket'])->name('createTicket');
    Route::post('/client/create-ticket', [CustomerController::class, 'storeTicket'])->name('storeTicket');

    // Vendor Routes
    Route::get('/v-bills', [VendorUserController::class, 'vBills'])->name('vBills');
    Route::get('/v-inventories', [VendorUserController::class, 'vInventories'])->name('vInventories');

    // Employee Routes
    Route::get('/my-attendance', [EmployeeController::class, 'myAttendance'])->name('myAttendance');
    Route::get('/emp-bills', [EmployeeController::class, 'empBills'])->name('empBills');
    Route::get('/my-bank-accounts', [EmployeeController::class, 'myBank'])->name('myBank');
    // Route::get('/emp-projects', [EmployeeController::class, 'empProjects'])->name('empProjects');
    Route::get('/emp-profile', [EmployeeController::class, 'empProfile'])->name('empProfile');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings', [SettingController::class, 'index'])->name('profile.settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Custom Routes for API Settings
    Route::get('/settings/api', [App\Http\Controllers\SettingController::class, 'apiSettings'])->name('settings.api');
    Route::post('/settings/api', [App\Http\Controllers\SettingController::class, 'updateApiSettings'])->name('settings.api.update');

    // GST Reports
    Route::get('/gst/dashboard', [App\Http\Controllers\GstReportController::class, 'index'])->name('gst.dashboard');
    Route::get('/gst/export-gstr1', [App\Http\Controllers\GstReportController::class, 'exportGstr1'])->name('gst.export.gstr1');
    Route::get('/gst/export-gstr2', [App\Http\Controllers\GstReportController::class, 'exportGstr2'])->name('gst.export.gstr2');
});
