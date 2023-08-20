<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\InventoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-inventory-type')) {
            $inventoryTypes = InventoryType::paginate(10);
            return view('crm.fields.inventory-types.index', compact('inventoryTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-inventory-type')) {
            return view('crm.fields.inventory-types.create');
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
            'name' => 'required|unique:inventory_types',
        ]);

        InventoryType::create([
            'name' => $request->name,
        ]);

        notify()->success('Inventory Type has been created');
        return redirect()->route('inventory-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryType $inventoryType)
    {
        if (Auth::user()->hasPermission('read-inventory-type')) {
            return view('crm.fields.inventory-types.show', compact('inventoryType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryType $inventoryType)
    {
        if (Auth::user()->hasPermission('update-inventory-type')) {
            return view('crm.fields.inventory-types.edit', compact('inventoryType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryType $inventoryType)
    {
        $request->validate([
            'name' => 'required|unique:inventory_types,name,' . $inventoryType->id,
        ]);

        $inventoryType->update($request->all());

        notify()->success('Inventory Type Updated');
        return redirect()->route('inventory-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryType $inventoryType)
    {
        if (Auth::user()->hasPermission('delete-inventory-type')) {
            $inventoryType->delete();
            notify()->success('Inventory Type Deleted');
            return redirect()->route('inventory-types.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
