<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Laratrust;

class TicketController extends Controller
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
        if (Auth::user()->hasPermission('manage-ticket')) {
            $chart_options = [
                'chart_title' => 'Tickets by priority',
                'report_type' => 'group_by_string',
                'model' => 'App\Models\Ticket',
                'group_by_field' => 'priority',
                // 'group_by_period' => 'month',
                // 'date_format' => 'M',
                'chart_type' => 'bar',
            ];

            $chart1 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Tickets by Status',
                'report_type' => 'group_by_string',
                'model' => 'App\Models\Ticket',
                'group_by_field' => 'status',
                // 'group_by_period' => 'day',
                // 'date_format' => 'D',
                'chart_type' => 'bar',
            ];

            $chart2 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Tickets by Type',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Ticket',
                'relationship_name' => 'ticketCategory',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart3 = new LaravelChart($chart_options);

            $searchQuery = $request->input('search');
            
            // Query Tickets with search keyword
            $ticketsQuery = Ticket::with(['ticketCategory', 'assignedUser', 'client',]);
            if ($searchQuery) {
                $ticketsQuery->where(function ($query) use ($searchQuery) {
                    $query->where('status', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('subject', 'LIKE', '%' . $searchQuery . '%');
                });
            }
            // Retrieve the paginated Tickets
            $tickets = $ticketsQuery->paginate(10);

            $ticketCategories = TicketCategory::all();
            return view('crm.crud.tickets.index', compact('tickets', 'ticketCategories', 'chart1', 'chart2', 'chart3'));
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-ticket')) {
            $ticketCategories = TicketCategory::all();
            $clients = User::whereHasRole(['client'])->get();
            $assignedUsers = User::whereHasRole(['supervisor', 'manager'])->get(); 
            return view('crm.crud.tickets.create', compact('ticketCategories', 'assignedUsers', 'clients'));
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
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'priority' => 'required|in:low,medium,high',
            'subject' => 'required|string',
            'message' => 'required|string',
            'status' => 'required|in:Answered,Pending',
            'client_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        // dd($request->all());
        Ticket::create($request->all());
        notify()->success('Ticket Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        if (Auth::user()->hasPermission('read-ticket')) {
            return view('crm.crud.tickets.show', compact('ticket'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        if (Auth::user()->hasPermission('update-ticket')) {
            $ticketCategories = TicketCategory::all();
            $clients = User::whereHasRole(['client'])->get();
            $assignedUsers = User::whereHasRole(['supervisor', 'manager'])->get();
            return view('crm.crud.tickets.edit', compact('ticket', 'ticketCategories', 'clients', 'assignedUsers'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'priority' => 'required|in:low,medium,high',
            'subject' => 'required|string',
            'message' => 'required|string',
            'status' => 'required|in:Answered,Pending',
            'client_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket->update($request->all());
        notify()->success('Ticket Updated');
        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        if (Auth::user()->hasPermission('delete-ticket')) {
            $ticket->delete();
            notify()->success('Ticket has been deleted');
            return redirect()->back();
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
