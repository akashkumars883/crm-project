<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\BillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-bill-type')) {
            $billTypes = BillType::paginate(10);
            return view('crm.fields.bill-types.index', compact('billTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-bill-type')) {
            return view('crm.fields.bill-types.create');
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
            'name' => 'required|unique:bill_types',
        ]);

        BillType::create([
            'name' => $request->name,
        ]);

        notify()->success('Bill Type has been created');
        return redirect()->route('bill-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BillType $billType)
    {
        if (Auth::user()->hasPermission('read-bill-type')) {
            return view('crm.fields.bill-types.show', compact('billType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillType $billType)
    {
        if (Auth::user()->hasPermission('update-bill-type')) {
            return view('crm.fields.bill-types.edit', compact('billType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillType $billType)
    {
        $request->validate([
            'name' => 'required|unique:bill_types,name,' . $billType->id,
        ]);

        $billType->update($request->all());

        notify()->success('Bill Type Updated');
        return redirect()->route('bill-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillType $billType)
    {
        if (Auth::user()->hasPermission('delete-bill-type')) {
            $billType->delete();
            notify()->success('Bill Type Deleted');
            return redirect()->route('bill-types.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
