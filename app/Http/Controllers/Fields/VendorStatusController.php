<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorStatus;
use Illuminate\Support\Facades\Auth;

class VendorStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-vendor-status')) {
            $vendorStatuses = VendorStatus::paginate(10);
            return view('crm.fields.vendor-statuses.index', compact('vendorStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-vendor-status')) {
            return view('crm.fields.vendor-statuses.create');
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
            'name' => 'required|unique:vendor_statuses',
        ]);

        VendorStatus::create([
            'name' => $request->name,
        ]);

        notify()->success('Vendor Status has been created');
        return redirect()->route('vendor-statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(VendorStatus $vendorStatus)
    {
        if (Auth::user()->hasPermission('read-vendor-status')) {
            return view('crm.fields.vendor-statuses.show', compact('vendorStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorStatus $vendorStatus)
    {
        if (Auth::user()->hasPermission('update-vendor-status')) {
            return view('crm.fields.vendor-statuses.edit', compact('vendorStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VendorStatus $vendorStatus)
    {
        $request->validate([
            'name' => 'required|unique:vendor_statuses,name,' . $vendorStatus->id,
        ]);

        $vendorStatus->update($request->all());

        notify()->success('Vendor Status Updated');
        return redirect()->route('vendor-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorStatus $vendorStatus)
    {
        if (Auth::user()->hasPermission('delete-vendor-status')) {
            $vendorStatus->delete();
            notify()->success('Vendor Status Deleted');
            return redirect()->route('vendor-statuses.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
