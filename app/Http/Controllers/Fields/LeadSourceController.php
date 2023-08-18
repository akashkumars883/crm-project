<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\LeadSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-lead-source')) {
            $leadSources = LeadSource::paginate(10);
            return view('crm.fields.lead-sources.index', compact('leadSources'));
        } else {
            abort(403, 'Unauthorized access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-lead-source')) {
            return view('crm.fields.lead-sources.create');
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
            'name' => 'required|unique:lead_sources',
        ]);

        LeadSource::create([
            'name' => $request->name,
        ]);

        notify()->success('A new Lead Source has been created');
        return redirect()->route('lead-sources.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadSource $leadSource)
    {
        if (Auth::user()->hasPermission('read-lead-source')) {
            return view('crm.fields.lead-sources.show', compact('leadSource'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadSource $leadSource)
    {
        if (Auth::user()->hasPermission('update-lead-source')) {
            return view('crm.fields.lead-sources.edit', compact('leadSource'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadSource $leadSource)
    {
        $request->validate([
            'name' => 'required|unique:lead_sources,name,' . $leadSource->id,
        ]);

        $leadSource->update($request->all());

        notify()->success('Lead Source Updated');
        return redirect()->route('lead-sources.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadSource $leadSource)
    {
        if (Auth::user()->hasPermission('delete-lead-source')) {
            $leadSource->delete();
            notify()->success('Lead Source Deleted Successfully');
            return redirect()->route('lead-sources.index');
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
