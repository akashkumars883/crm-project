<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\Auth;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-ticket-category')) {
            $ticketCategories = TicketCategory::paginate(10);
            return view('crm.fields.ticket-categories.index', compact('ticketCategories'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-ticket-category')) {
            return view('crm.fields.ticket-categories.create');
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
            'name' => 'required|unique:ticket_categories',
        ]);

        TicketCategory::create([
            'name' => $request->name,
        ]);

        notify()->success('Ticket Category has been created');
        return redirect()->route('ticket-categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketCategory $ticketCategory)
    {
        if (Auth::user()->hasPermission('read-ticket-category')) {
            return view('crm.fields.ticket-categories.show', compact('ticketCategory'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketCategory $ticketCategory)
    {
        if (Auth::user()->hasPermission('update-ticket-category')) {
            return view('crm.fields.ticket-categories.edit', compact('ticketCategory'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketCategory $ticketCategory)
    {
        $request->validate([
            'name' => 'required|unique:ticket_categories,name,' . $ticketCategory->id,
        ]);

        $ticketCategory->update($request->all());

        notify()->success('Ticket Category Updated');
        return redirect()->route('ticket-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketCategory $ticketCategory)
    {
        if (Auth::user()->hasPermission('delete-ticket-category')) {
            $ticketCategory->delete();
            notify()->success('Ticket Category Deleted');
            return redirect()->route('ticket-categories.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
