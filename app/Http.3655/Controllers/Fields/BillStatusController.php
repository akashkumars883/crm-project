<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\BillStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-bill-status')) {
            $billStatuses = BillStatus::paginate(10);
            return view('crm.fields.bill-statuses.index', compact('billStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-bill-status')) {
            return view('crm.fields.bill-statuses.create');
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
            'name' => 'required|unique:bill_statuses',
        ]);

        BillStatus::create([
            'name' => $request->name,
        ]);

        notify()->success('Bill Status has been created');
        return redirect()->route('bill-statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BillStatus $billStatus)
    {
        if (Auth::user()->hasPermission('read-bill-status')) {
            return view('crm.fields.bill-statuses.show', compact('billStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillStatus $billStatus)
    {
        if (Auth::user()->hasPermission('update-bill-status')) {
            return view('crm.fields.bill-statuses.edit', compact('billStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillStatus $billStatus)
    {
        $request->validate([
            'name' => 'required|unique:bill_statuses,name,' . $billStatus->id,
        ]);

        $billStatus->update($request->all());

        notify()->success('Bill Status Updated');
        return redirect()->route('bill-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillStatus $billStatus)
    {
        if (Auth::user()->hasPermission('delete-bill-status')) {
            $billStatus->delete();
            notify()->success('Bill Status Deleted');
            return redirect()->route('bill-statuses.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
