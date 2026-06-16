<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\VendorStatus;
use App\Models\VendorType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class VendorController extends Controller
{
    protected $previousUrl;

    public function __construct()
    {
        $this->previousUrl = URL::previous();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('manage-vendor')) {
            $chart_options = [
                'chart_title' => 'Vendors by month',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Vendor',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'date_format' => 'M',
                'chart_type' => 'bar',
            ];

            $chart1 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Vendors by Type',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Vendor',
                'relationship_name' => 'vendorType',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart2 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Vendors by Status',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Vendor',
                'relationship_name' => 'vendorStatus',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart3 = new LaravelChart($chart_options);

            $searchQuery = $request->input('search');
            
            // Query vendor with search keyword
            $vendorsQuery = Vendor::with(['vendorStatus', 'vendorType']);
            if ($searchQuery) {
                $vendorsQuery->where(function ($query) use ($searchQuery) {
                    $query->where('id', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('name', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('address', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhereHas('vendorType', function ($typeQuery) use ($searchQuery) {
                            $typeQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('vendorStatus', function ($statusQuery) use ($searchQuery) {
                            $statusQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        });
                });
            }

            $vendors = $vendorsQuery->paginate(10);
            
            return view('crm.crud.vendors.index', compact('vendors', 'chart1', 'chart2', 'chart3'));
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-vendor')) {
            $vendorTypes = VendorType::all();
            $vendorStatuses = VendorStatus::all();
            return view('crm.crud.vendors.create', compact('vendorTypes', 'vendorStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_type_id' => 'required|exists:vendor_types,id',
            'vendor_status_id' => 'required|exists:vendor_statuses,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        Vendor::create($request->all());
        notify()->success('Vendor Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        if (Auth::user()->hasPermission('read-vendor')) {
            $vendorId = $vendor->id;
            $bills = $vendor->bills()->paginate(8);
            $inventories = $vendor->inventories()->paginate(8);
            return view('crm.crud.vendors.show', compact('vendor', 'inventories', 'bills'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        if (Auth::user()->hasPermission('update-vendor')) {
            $vendorTypes = VendorType::all();
            $vendorStatuses = VendorStatus::all();
            return view('crm.crud.vendors.edit', compact('vendor', 'vendorTypes', 'vendorStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        if (Auth::user()->hasPermission('delete-vendor')) {
            $request->validate([
                'vendor_type_id' => 'required|exists:vendor_types,id',
                'vendor_status_id' => 'required|exists:vendor_statuses,id',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
            ]);

            $vendor->update($request->all());
            notify()->success('Vendor Updated');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        notify()->success('Vendor Deleted');
        return redirect()->back();
    }
}
