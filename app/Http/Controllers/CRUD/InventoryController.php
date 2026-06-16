<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryStatus;
use App\Models\InventoryType;
use App\Models\Project;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class InventoryController extends Controller
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
        if (Auth::user()->hasPermission('manage-inventory')) {
            $chart_options = [
                'chart_title' => 'Inventories by Type',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Inventory',
                'relationship_name' => 'inventoryType',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart1 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Inventories by Status',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Inventory',
                'relationship_name' => 'inventoryStatus',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart2 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Inventories by Vendor',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Inventory',
                'relationship_name' => 'vendor',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart3 = new LaravelChart($chart_options);

            $searchQuery = $request->input('search');
            
            // Query Inventories with search keyword
            $inventoriesQuery = Inventory::with(['inventoryType', 'inventoryStatus', 'vendor',]);
            if ($searchQuery) {
                $inventoriesQuery->where(function ($query) use ($searchQuery) {
                    $query->where('title', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('cost', 'LIKE', '%' . $searchQuery . '%');
                })
                ->orWhereHas('inventoryType', function ($typeQuery) use ($searchQuery) {
                    $typeQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                })
                ->orWhereHas('inventoryStatus', function ($statusQuery) use ($searchQuery) {
                    $statusQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                })
                ->orWhereHas('vendor', function ($vendorQuery) use ($searchQuery) {
                    $vendorQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                });
            }
            // Retrieve the paginated inventories
            $inventories = $inventoriesQuery->paginate(10);
            return view('crm.crud.inventories.index', compact('inventories', 'chart1', 'chart2', 'chart3'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-inventory')) {
            $inventoryStatuses = InventoryStatus::all();
            $inventoryTypes = InventoryType::all();
            $vendors = Vendor::all();
            $projects = Project::all();
            return view('crm.crud.inventories.create', compact('inventoryStatuses', 'projects', 'inventoryTypes', 'vendors'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'inventory_status_id' => 'required',
            'inventory_type_id' => 'required',
            'vendor_id' => 'required',
            'title' => 'required|max:255',
            'description' => 'nullable',
            'cost' => 'nullable',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        Inventory::create($validatedData);
        notify()->success('Inventory Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        if (Auth::user()->hasPermission('read-inventory')) {
            return view('crm.crud.inventories.show', compact('inventory'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        if (Auth::user()->hasPermission('update-inventory')) {
            $inventoryTypes = InventoryType::all();
            $inventoryStatuses = InventoryStatus::all();
            $vendors = Vendor::all();
            $projects = Project::all();
            return view('crm.crud.inventories.edit', compact('inventoryTypes', 'projects', 'inventoryStatuses', 'vendors', 'inventory'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validatedData = $request->validate([
            'inventory_status_id' => 'required',
            'inventory_type_id' => 'required',
            'vendor_id' => 'required',
            'title' => 'required|max:255',
            'description' => 'nullable',
            'cost' => 'nullable',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $inventory->update($request->all());
        notify()->success('Inventory Updated');
        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        if (Auth::user()->hasPermission('delete-inventory')) {
            $inventory->delete();
            notify()->success('Inventory Deleted Successfully');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
