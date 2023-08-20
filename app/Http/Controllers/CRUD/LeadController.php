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
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('manage-lead')) {
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
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-lead')) {
            $leadSources = LeadSource::all();
            $leadStatuses = LeadStatus::all();
            $contactMethods = ContactMethod::all();
            $contactLanguages = ContactLanguage::all();
            $users = User::all();
            return view('crm.crud.leads.create', compact('leadSources', 'users', 'contactMethods', 'contactLanguages', 'leadStatuses'));
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
            'lead_source_id' => 'required|exists:lead_sources,id',
            'lead_status_id' => 'required|exists:lead_statuses,id',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'zip' => 'nullable',
            'notes' => 'nullable',
            'contact_method_id' => 'nullable|exists:contact_methods,id',
            'contact_language_id' => 'nullable|exists:contact_languages,id',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        Lead::create($request->all());
        notify()->success('Lead Created');
        return redirect()->route('leads.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        if (Auth::user()->hasPermission('read-lead')) {
            return view('crm.crud.leads.show', compact('lead'));
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        if (Auth::user()->hasPermission('update-lead')) {
            $leadSources = LeadSource::all();
            $leadStatuses = LeadStatus::all();
            $contactMethods = ContactMethod::all();
            $contactLanguages = ContactLanguage::all();
            $users = User::all();
            return view('crm.crud.leads.edit', compact('lead', 'contactMethods', 'contactLanguages', 'leadSources', 'leadStatuses', 'users'));
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'lead_source_id' => 'required|exists:lead_sources,id',
            'lead_status_id' => 'required|exists:lead_statuses,id',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'zip' => 'nullable',
            'notes' => 'nullable',
            'contact_method_id' => 'nullable|exists:contact_methods,id',
            'contact_language_id' => 'nullable|exists:contact_languages,id',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        $lead->update($request->all());
        notify()->success('Lead Updatedd');
        return redirect()->route('leads.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        if (Auth::user()->hasPermission('delete-lead')) {
            $lead->delete();
            notify()->success('Lead Deleted Successfully');
            return redirect()->route('leads.index');
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }
}
