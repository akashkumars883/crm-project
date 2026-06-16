<?php

namespace App\Http\Controllers;

use App\Models\AttendanceStatus;
use App\Models\AttendanceType;
use App\Models\AttendanceRecord;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\EmployeeUser;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorUser;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // ── Admin / Super-Admin ───────────────────────────────────────────
        if (Auth::user()->hasRole(['admin', 'super-admin'])) {

            $usersCount       = User::count();
            $adminsCount      = User::whereHasRole('admin')->count();
            $managersCount    = User::whereHasRole('manager')->count();
            $supervisorsCount = User::whereHasRole('supervisor')->count();
            $accountsCount    = User::whereHasRole('accounts')->count();
            $hrCount          = User::whereHasRole('hr')->count();
            $employeesCount   = EmployeeUser::count();
            $customersCount   = Customer::count();
            $vendorsCount     = VendorUser::count();

            $leadsByMonth       = new LaravelChart(['chart_title' => 'Leads',       'report_type' => 'group_by_date', 'model' => 'App\Models\Lead',       'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $invoicesByMonth    = new LaravelChart(['chart_title' => 'Invoices',    'report_type' => 'group_by_date', 'model' => 'App\Models\Invoice',    'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $projectsByMonth    = new LaravelChart(['chart_title' => 'Projects',    'report_type' => 'group_by_date', 'model' => 'App\Models\Project',    'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $inventoriesByMonth = new LaravelChart(['chart_title' => 'Inventories', 'report_type' => 'group_by_date', 'model' => 'App\Models\Inventory',  'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $paymentsByMonth    = new LaravelChart(['chart_title' => 'Payments',    'report_type' => 'group_by_date', 'model' => 'App\Models\Payment',    'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $billsByMonth       = new LaravelChart(['chart_title' => 'Bills',       'report_type' => 'group_by_date', 'model' => 'App\Models\Bill',       'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $ticketsByMonth     = new LaravelChart(['chart_title' => 'Tickets',     'report_type' => 'group_by_date', 'model' => 'App\Models\Ticket',     'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'pie']);
            $activitiesByMonth  = new LaravelChart(['chart_title' => 'Activities',  'report_type' => 'group_by_date', 'model' => 'App\Models\Activity',   'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'pie']);
            $rolesChart         = new LaravelChart(['chart_title' => 'Roles',       'report_type' => 'group_by_string', 'model' => 'App\Models\Role',     'group_by_field' => 'name',                                                              'chart_type' => 'pie']);

            $recentLeads   = Lead::latest()->take(5)->get();
            $activeProjects = \App\Models\Project::with('projectStatus', 'customer.lead')->latest()->take(5)->get();

            // New Analytics for Dashboard
            $totalRevenue = Payment::sum('amount');
            $totalExpenses = Expense::where('status', 'Approved')->sum('amount');
            
            $totalLeads = Lead::count();
            $leadConversionRate = $totalLeads > 0 ? round(($customersCount / $totalLeads) * 100, 2) : 0;

            return view('dashboards.admin', compact(
                'usersCount', 'vendorsCount', 'customersCount', 'employeesCount',
                'hrCount', 'adminsCount', 'managersCount', 'supervisorsCount', 'accountsCount',
                'leadsByMonth', 'invoicesByMonth', 'projectsByMonth', 'inventoriesByMonth',
                'paymentsByMonth', 'billsByMonth', 'rolesChart', 'recentLeads', 'activeProjects',
                'totalRevenue', 'totalExpenses', 'leadConversionRate'
            ));
        }

        // ── Manager ───────────────────────────────────────────────────────
        elseif (Auth::user()->hasRole('manager')) {

            $usersCount       = User::count();
            $adminsCount      = User::whereHasRole('admin')->count();
            $managersCount    = User::whereHasRole('manager')->count();
            $supervisorsCount = User::whereHasRole('supervisor')->count();
            $accountsCount    = User::whereHasRole('accounts')->count();
            $hrCount          = User::whereHasRole('hr')->count();
            $employeesCount   = EmployeeUser::count();
            $customersCount   = Customer::count();
            $vendorsCount     = VendorUser::count();

            $leadsByMonth       = new LaravelChart(['chart_title' => 'Leads',       'report_type' => 'group_by_date', 'model' => 'App\Models\Lead',      'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $invoicesByMonth    = new LaravelChart(['chart_title' => 'Invoices',    'report_type' => 'group_by_date', 'model' => 'App\Models\Invoice',   'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $projectsByMonth    = new LaravelChart(['chart_title' => 'Projects',    'report_type' => 'group_by_date', 'model' => 'App\Models\Project',   'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $inventoriesByMonth = new LaravelChart(['chart_title' => 'Inventories', 'report_type' => 'group_by_date', 'model' => 'App\Models\Inventory', 'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $paymentsByMonth    = new LaravelChart(['chart_title' => 'Payments',    'report_type' => 'group_by_date', 'model' => 'App\Models\Payment',   'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $billsByMonth       = new LaravelChart(['chart_title' => 'Bills',       'report_type' => 'group_by_date', 'model' => 'App\Models\Bill',      'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $ticketsByMonth     = new LaravelChart(['chart_title' => 'Tickets',     'report_type' => 'group_by_date', 'model' => 'App\Models\Ticket',    'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'pie']);
            $activitiesByMonth  = new LaravelChart(['chart_title' => 'Activities',  'report_type' => 'group_by_date', 'model' => 'App\Models\Activity',  'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'pie']);

            $recentLeads   = Lead::latest()->take(5)->get();
            $activeProjects = \App\Models\Project::with('projectStatus', 'customer.lead')->latest()->take(5)->get();

            return view('dashboards.manager', compact(
                'usersCount', 'vendorsCount', 'customersCount', 'employeesCount',
                'hrCount', 'adminsCount', 'managersCount', 'supervisorsCount', 'accountsCount',
                'leadsByMonth', 'invoicesByMonth', 'projectsByMonth', 'inventoriesByMonth',
                'paymentsByMonth', 'billsByMonth', 'recentLeads', 'activeProjects'
            ));
        }

        // ── Supervisor ────────────────────────────────────────────────────
        elseif (Auth::user()->hasRole('supervisor')) {

            $usersCount       = User::count();
            $adminsCount      = User::whereHasRole('admin')->count();
            $managersCount    = User::whereHasRole('manager')->count();
            $supervisorsCount = User::whereHasRole('supervisor')->count();
            $accountsCount    = User::whereHasRole('accounts')->count();
            $hrCount          = User::whereHasRole('hr')->count();
            $employeesCount   = EmployeeUser::count();
            $customersCount   = Customer::count();
            $vendorsCount     = VendorUser::count();

            $leadsByMonth       = new LaravelChart(['chart_title' => 'Leads',       'report_type' => 'group_by_date', 'model' => 'App\Models\Lead',      'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $invoicesByMonth    = new LaravelChart(['chart_title' => 'Invoices',    'report_type' => 'group_by_date', 'model' => 'App\Models\Invoice',   'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $projectsByMonth    = new LaravelChart(['chart_title' => 'Projects',    'report_type' => 'group_by_date', 'model' => 'App\Models\Project',   'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $inventoriesByMonth = new LaravelChart(['chart_title' => 'Inventories', 'report_type' => 'group_by_date', 'model' => 'App\Models\Inventory', 'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $paymentsByMonth    = new LaravelChart(['chart_title' => 'Payments',    'report_type' => 'group_by_date', 'model' => 'App\Models\Payment',   'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $billsByMonth       = new LaravelChart(['chart_title' => 'Bills',       'report_type' => 'group_by_date', 'model' => 'App\Models\Bill',      'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $ticketsByMonth     = new LaravelChart(['chart_title' => 'Tickets',     'report_type' => 'group_by_date', 'model' => 'App\Models\Ticket',    'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'pie']);
            $activitiesByMonth  = new LaravelChart(['chart_title' => 'Activities',  'report_type' => 'group_by_date', 'model' => 'App\Models\Activity',  'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'pie']);

            return view('dashboards.supervisor', compact(
                'usersCount', 'vendorsCount', 'customersCount', 'employeesCount',
                'hrCount', 'adminsCount', 'managersCount', 'supervisorsCount', 'accountsCount',
                'leadsByMonth', 'invoicesByMonth', 'projectsByMonth', 'inventoriesByMonth',
                'paymentsByMonth', 'billsByMonth', 'ticketsByMonth', 'activitiesByMonth',
            ));
        }

        // ── Accounts ──────────────────────────────────────────────────────
        elseif (Auth::user()->hasRole('accounts')) {

            $paymentsByMonth = new LaravelChart(['chart_title' => 'Payments', 'report_type' => 'group_by_date', 'model' => 'App\Models\Payment', 'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $billsByMonth    = new LaravelChart(['chart_title' => 'Bills',    'report_type' => 'group_by_date', 'model' => 'App\Models\Bill',    'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'line']);
            $invoicesByMonth = new LaravelChart(['chart_title' => 'Invoices', 'report_type' => 'group_by_date', 'model' => 'App\Models\Invoice', 'group_by_field' => 'created_at', 'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);

            return view('dashboards.accounts', compact('paymentsByMonth', 'billsByMonth', 'invoicesByMonth'));
        }

        // ── HR ────────────────────────────────────────────────────────────
        elseif (Auth::user()->hasRole('hr')) {

            $employeeByYearChart    = new LaravelChart(['chart_title' => 'Employees by year',  'report_type' => 'group_by_date',         'model' => 'App\Models\Employee',         'group_by_field' => 'created_at',  'group_by_period' => 'year',  'date_format' => 'Y', 'chart_type' => 'bar']);
            $employeeByMonthChart   = new LaravelChart(['chart_title' => 'Employees by month', 'report_type' => 'group_by_date',         'model' => 'App\Models\Employee',         'group_by_field' => 'created_at',  'group_by_period' => 'month', 'date_format' => 'M', 'chart_type' => 'bar']);
            $employeeByDayChart     = new LaravelChart(['chart_title' => 'Employees by day',   'report_type' => 'group_by_date',         'model' => 'App\Models\Employee',         'group_by_field' => 'created_at',  'group_by_period' => 'day',   'date_format' => 'D', 'chart_type' => 'bar']);
            $attendanceByDayChart   = new LaravelChart(['chart_title' => 'Attendance by day',  'report_type' => 'group_by_string',       'model' => 'App\Models\AttendanceRecord', 'group_by_field' => 'date',        'group_by_period' => 'day',   'date_format' => 'D', 'chart_type' => 'bar']);
            $attendanceByTypeChart  = new LaravelChart(['chart_title' => 'Attendance by Type', 'report_type' => 'group_by_relationship', 'model' => 'App\Models\AttendanceRecord', 'relationship_name' => 'attendanceType',   'group_by_field' => 'name', 'chart_type' => 'bar']);
            $attendanceByStatusChart= new LaravelChart(['chart_title' => 'Attendance by Status','report_type'=> 'group_by_relationship', 'model' => 'App\Models\AttendanceRecord', 'relationship_name' => 'attendanceStatus', 'group_by_field' => 'name', 'chart_type' => 'bar']);

            return view('dashboards.hr', compact(
                'employeeByYearChart', 'employeeByMonthChart', 'employeeByDayChart',
                'attendanceByDayChart', 'attendanceByTypeChart', 'attendanceByStatusChart',
            ));
        }

        // ── Employee ──────────────────────────────────────────────────────
        elseif (Auth::user()->hasRole('employee')) {

            $authId  = Auth::user()->id;
            $empUser = EmployeeUser::where('user_id', $authId)->first();
            $eId     = $empUser ? $empUser->employee_id : null;
            $employee = $eId ? Employee::where('id', $eId)->first() : null;

            $currentDate     = Carbon::now()->toDateString();
            $attendanceRecords = $employee ? $employee->attendanceRecords()->latest()->paginate(10) : collect();
            $recordExistsToday = $employee ? AttendanceRecord::where('employee_id', $employee->id)->whereDate('date', $currentDate)->exists() : false;

            $AttendanceTypeAnalytics   = AttendanceType::select('id','name')->withCount('attendanceRecords')->get();
            $AttendanceStatusAnalytics = AttendanceStatus::select('id','name')->withCount('attendanceRecords')->get();

            return view('dashboards.employee', compact(
                'AttendanceTypeAnalytics',
                'AttendanceStatusAnalytics',
            ));
        }

        // ── Vendor ────────────────────────────────────────────────────────
        elseif (Auth::user()->hasRole('vendor')) {

            $userId           = Auth::user()->id;
            $vendorUser       = VendorUser::where('user_id', $userId)->first();
            $vendorId         = $vendorUser ? $vendorUser->vendor_id : null;
            $vendor           = $vendorId ? Vendor::where('id', $vendorId)->first() : null;
            $inventoriesCount = $vendorId ? Inventory::where('vendor_id', $vendorId)->count() : 0;
            $billsCount       = $vendor ? $vendor->bills()->count() : 0;

            return view('dashboards.vendor', compact('inventoriesCount', 'billsCount'));
        }

        // ── Client ────────────────────────────────────────────────────────
        elseif (Auth::user()->hasRole('client')) {

            $authId        = Auth::user()->id;
            $customer      = Customer::where('user_id', $authId)->first();
            $lead          = $customer ? $customer->lead : null;
            $leadId        = $lead ? $lead->id : null;
            $ticketsCount  = Ticket::where('client_id', $authId)->count();
            $paymentsCount = $customer ? $customer->payments()->count() : 0;
            $projectsCount = $customer ? $customer->projects()->count() : 0;
            $invoicesCount = $leadId ? Invoice::where('lead_id', $leadId)->count() : 0;

            $recentProjects = $customer ? $customer->projects()->with('projectType', 'projectStatus')->latest()->take(3)->get() : collect();
            $recentInvoices = $leadId ? Invoice::where('lead_id', $leadId)->latest()->take(3)->get() : collect();

            return view('dashboards.client', compact(
                'ticketsCount', 'paymentsCount', 'projectsCount', 'invoicesCount',
                'recentProjects', 'recentInvoices',
            ));
        }

        // ── Fallback ─────────────────────────────────────────────────────
        abort(403, 'Unauthorized - No valid role assigned');
    }
}