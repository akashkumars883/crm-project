<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\User;
use App\Models\ContactMethod;
use App\Models\ContactLanguage;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');
        // Get all lead statuses with their corresponding lead counts
        $leadStatusAnalytics = LeadStatus::select('id', 'name')
            ->withCount('leads')
            ->get();
        // Get all lead sources with their corresponding lead counts
        $leadSourceAnalytics = LeadSource::select('id', 'name')
            ->withCount('leads')
            ->get();
        // Query leads with search keyword
        $leadsQuery = Lead::with(['leadSource', 'leadStatus', 'assignedTo']);
        if ($searchQuery) {
            $leadsQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('address', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('city', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('state', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('zip', 'LIKE', '%' . $searchQuery . '%');
            });
        }
        // Retrieve the paginated leads
        $leads = $leadsQuery->paginate(10);
        return view('crm.crud.leads.index', compact('leads', 'leadStatusAnalytics', 'leadSourceAnalytics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
