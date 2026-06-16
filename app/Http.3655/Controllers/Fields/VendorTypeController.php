<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorType;
use Illuminate\Support\Facades\Auth;

class VendorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-vendor-type')) {
            $vendorTypes = VendorType::paginate(10);
            return view('crm.fields.vendor-types.index', compact('vendorTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-vendor-type')) {
            return view('crm.fields.vendor-types.create');
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
            'name' => 'required|unique:vendor_types',
        ]);

        VendorType::create([
            'name' => $request->name,
        ]);

        notify()->success('Vendor Type has been created');
        return redirect()->route('vendor-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(VendorType $vendorType)
    {
        if (Auth::user()->hasPermission('read-vendor-type')) {
            return view('crm.fields.vendor-types.show', compact('vendorType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorType $vendorType)
    {
        if (Auth::user()->hasPermission('update-vendor-type')) {
            return view('crm.fields.vendor-types.edit', compact('vendorType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VendorType $vendorType)
    {
        $request->validate([
            'name' => 'required|unique:vendor_types,name,' . $vendorType->id,
        ]);

        $vendorType->update($request->all());

        notify()->success('Vendor Type Updated');
        return redirect()->route('vendor-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorType $vendorType)
    {
        if (Auth::user()->hasPermission('delete-vendor-type')) {
            $vendorType->delete();
            notify()->success('Vendor Type Deleted');
            return redirect()->route('vendor-types.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
