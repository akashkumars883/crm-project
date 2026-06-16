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
        if (Auth::user()->hasRole('admin')) {
            return view('home');
        } 
        elseif (Auth::user()->hasRole('manager')) {
            return view('home');
        }
        elseif (Auth::user()->hasRole('supervisor')) {
            return view('home');
        }
        elseif (Auth::user()->hasRole('accounts')) {
            return view('home');
        }
        elseif (Auth::user()->hasRole('hr')) {
            return view('home');
        }
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
            
                return view('home', compact(
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

            return view('home', compact(
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

            return view('home', compact(
                'ticketsCount',
                'paymentsCount',
                'projectsCount',
                'invoicesCount',
            ));
        }
    }
}
