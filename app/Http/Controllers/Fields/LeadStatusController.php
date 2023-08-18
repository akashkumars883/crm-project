<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-lead-status')) {
            $leadStatuses = LeadStatus::paginate(10);
            return view('crm.fields.lead-statuses.index', compact('leadStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-lead-status')) {
            return view('crm.fields.lead-statuses.create');
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
            'name' => 'required|unique:lead_statuses',
        ]);

        LeadStatus::create([
            'name' => $request->name,
        ]);

        notify()->success('Lead Status has been created');
        return redirect()->route('lead-statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadStatus $leadStatus)
    {
        if (Auth::user()->hasPermission('read-lead-status')) {
            return view('crm.fields.lead-statuses.show', compact('leadStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadStatus $leadStatus)
    {
        if (Auth::user()->hasPermission('update-lead-status')) {
            return view('crm.fields.lead-statuses.edit', compact('leadStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadStatus $leadStatus)
    {
        $request->validate([
            'name' => 'required|unique:lead_statuses,name,' . $leadStatus->id,
        ]);

        $leadStatus->update($request->all());

        notify()->success('Lead Status Updated');
        return redirect()->route('lead-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadStatus $leadStatus)
    {
        if (Auth::user()->hasPermission('delete-lead-status')) {
            $leadStatus->delete();
            notify()->success('Lead Status Deleted');
            return redirect()->route('lead-statuses.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
