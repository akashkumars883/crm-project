<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\InventoryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-inventory-status')) {
            $inventoryStatuses = InventoryStatus::paginate(10);
            return view('crm.fields.inventory-statuses.index', compact('inventoryStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-inventory-status')) {
            return view('crm.fields.inventory-statuses.create');
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
            'name' => 'required|unique:inventory_statuses',
        ]);

        InventoryStatus::create([
            'name' => $request->name,
        ]);

        notify()->success('Inventory Status has been created');
        return redirect()->route('inventory-statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryStatus $inventoryStatus)
    {
        if (Auth::user()->hasPermission('read-inventory-status')) {
            return view('crm.fields.inventory-statuses.show', compact('inventoryStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryStatus $inventoryStatus)
    {
        if (Auth::user()->hasPermission('update-inventory-status')) {
            return view('crm.fields.inventory-statuses.edit', compact('inventoryStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryStatus $inventoryStatus)
    {
        $request->validate([
            'name' => 'required|unique:inventory_statuses,name,' . $inventoryStatus->id,
        ]);

        $inventoryStatus->update($request->all());

        notify()->success('Inventory Status Updated');
        return redirect()->route('inventory-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryStatus $inventoryStatus)
    {
        if (Auth::user()->hasPermission('delete-inventory-status')) {
            $inventoryStatus->delete();
            notify()->success('Inventory Status Deleted');
            return redirect()->route('inventory-statuses.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
