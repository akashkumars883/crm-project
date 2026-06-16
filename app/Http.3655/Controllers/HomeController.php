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
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $chart_options = [
            'chart_title' => 'Employees by year',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Employee',
            'group_by_field' => 'created_at',
            'group_by_period' => 'year',
            'date_format' => 'Y',
            'chart_type' => 'bar',
        ];
        $employeeByYearChart = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Employees by month',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Employee',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'bar',
        ];
        $employeeByMonthChart = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Employees by day',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Employee',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'date_format' => 'D',
            'chart_type' => 'bar',
        ];
        $employeeByDayChart = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Attendance by day',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\AttendanceRecord',
            'group_by_field' => 'date',
            'group_by_period' => 'day',
            'date_format' => 'D',
            'chart_type' => 'bar',
        ];
        $attendanceByDayChart = new LaravelChart($chart_options);
            
        $chart_options = [
            'chart_title' => 'Attendance by Type',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\AttendanceRecord',
            'relationship_name' => 'attendanceType',
            'group_by_field' => 'name',
            'group_by_period' => 'day',
            'date_format' => 'D',
            'chart_type' => 'bar',
        ];
        $attendanceByTypeChart = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Attendance by Status',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\AttendanceRecord',
            'relationship_name' => 'attendanceStatus',
            'group_by_field' => 'name',
            'chart_type' => 'bar',
        ];
        $attendanceByStatusChart = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Leads',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Lead',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'bar',
        ];
        $leadsByMonth = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Invoices',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Invoice',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'bar',
        ];
        $invoicesByMonth = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Projects',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Project',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'bar',
        ];
        $projectsByMonth = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Inventories',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Inventory',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'line',
        ];
        $inventoriesByMonth = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Payments',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Payment',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'line',
        ];
        $paymentsByMonth = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Bills',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Bill',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'line',
        ];
        $billsByMonth = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Tickets',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Ticket',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'pie',
        ];
        $ticketsByMonth = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Activities',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Activity',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'pie',
        ];
        $activitiesByMonth = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Roles',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Role',
            'group_by_field' => 'name',
            'group_by_period' => 'month',
            'date_format' => 'M',
            'chart_type' => 'pie',
        ];
        $rolesChart = new LaravelChart($chart_options);

        // Counters
        $usersCount = User::count();
        $adminsCount = User::whereHasRole('admin')->count();
        $managersCount = User::whereHasRole('manager')->count();
        $supervisorsCount = User::whereHasRole('supervisor')->count();
        $accountsCount = User::whereHasRole('accounts')->count();
        $hrCount = User::whereHasRole('hr')->count();
        $employeesCount = EmployeeUser::count();
        $customersCount = Customer::count();
        $vendorsCount = VendorUser::count();
        
        // Admin  Dashboard
        if (Auth::user()->hasRole(['admin', 'super-admin'])) {
            return view('dashboards.admin', compact(
                'usersCount',
                'vendorsCount',
                'customersCount',
                'employeesCount',
                'hrCount',
                'adminsCount',
                'managersCount',
                'supervisorsCount',
                'accountsCount',
                'leadsByMonth',
                'invoicesByMonth',
                'projectsByMonth',
                'inventoriesByMonth',
                'paymentsByMonth',
                'billsByMonth',
                'ticketsByMonth',
                'activitiesByMonth',
                'rolesChart',
            ));
        } 

        // Manager Dashboard
        elseif (Auth::user()->hasRole('manager')) {
            return view('dashboards.manager', compact(
                'usersCount',
                'vendorsCount',
                'customersCount',
                'employeesCount',
                'hrCount',
                'adminsCount',
                'managersCount',
                'supervisorsCount',
                'accountsCount',
                'leadsByMonth',
                'invoicesByMonth',
                'projectsByMonth',
                'inventoriesByMonth',
                'paymentsByMonth',
                'billsByMonth',
                'ticketsByMonth',
                'activitiesByMonth',
            ));
        }

        // Supervisor Dashboard
        elseif (Auth::user()->hasRole('supervisor')) {
            return view('dashboards.supervisor', compact(
                'usersCount',
                'vendorsCount',
                'customersCount',
                'employeesCount',
                'hrCount',
                'adminsCount',
                'managersCount',
                'supervisorsCount',
                'accountsCount',
                'leadsByMonth',
                'invoicesByMonth',
                'projectsByMonth',
                'inventoriesByMonth',
                'paymentsByMonth',
                'billsByMonth',
                'ticketsByMonth',
                'activitiesByMonth',
            ));
        }

        // Accounts Dashboard
        elseif (Auth::user()->hasRole('accounts')) {
            return view('dashboards.accounts', compact(
                'paymentsByMonth',
                'billsByMonth',
                'invoicesByMonth',
            ));
        }

        // HR Dashboard
        elseif (Auth::user()->hasRole('hr')) {
            return view('dashboards.hr', compact(
                'employeeByYearChart',
                'employeeByMonthChart',
                'employeeByDayChart',
                'attendanceByDayChart',
                'attendanceByTypeChart',
                'attendanceByStatusChart',
            ));
        }

        // Employee Dashboard
        elseif (Auth::user()->hasRole('employee')) {
            // Employee Analytics
            $authId = Auth::user()->id;
            $empUser = EmployeeUser::where('user_id', $authId)->first();
            $eId = $empUser->employee_id;
            $employee = Employee::where('id', $eId)->first();
            $attendanceRecords = $employee->attendanceRecords()->latest()->paginate(10);
             // Get the current date
            $currentDate = Carbon::now()->toDateString();

            $AttendanceTypeAnalytics = AttendanceType::select('id', 'name')
                ->withCount('attendanceRecords')
                ->get();

            $AttendanceStatusAnalytics = AttendanceStatus::select('id', 'name')
                ->withCount('attendanceRecords')
                ->get();

            // Check if a record exists for today's date
            $recordExistsToday = AttendanceRecord::where('employee_id', $employee->id)
                ->whereDate('date', $currentDate)
                ->exists();
            
                return view('dashboards.employee', compact(
                'AttendanceTypeAnalytics',
                'AttendanceStatusAnalytics',
            ));
        }
        elseif (Auth::user()->hasRole('vendor')) {
            // Vendor Analytics
            $userId = Auth::user()->id;
            $vendorUser = VendorUser::where('user_id', $userId)->first();
            $vendorId = $vendorUser->vendor_id;
            $vendor = Vendor::where('id', $vendorId)->first();
            $inventoriesCount = Inventory::where('vendor_id', $vendorId)->count();
            $billsCount = $vendor->bills()->count();

            return view('dashboards.vendor', compact(
                'inventoriesCount',
                'billsCount',
            ));
        }
        elseif (Auth::user()->hasRole('client')) {
            // Client Analytics
            $authId = Auth::user()->id;
            $customer = Customer::where('user_id', $authId)->first();
            $leadId = $customer->lead->id;
            $ticketsCount = Ticket::where('client_id', $authId)->count();
            $paymentsCount = $customer->payments()->count();
            $projectsCount = $customer->projects()->count();
            $invoicesCount = Invoice::where('lead_id', $leadId)->count();

            return view('dashboards.client', compact(
                'ticketsCount',
                'paymentsCount',
                'projectsCount',
                'invoicesCount',
            ));
        }
    }
}
