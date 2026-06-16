<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\URL;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\User;

class MyTicketsController extends Controller
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
        if (Auth::user()->hasPermission('manage-my-tickets')) {
            $user = Auth::user();

            $searchQuery = $request->input('search');
            
            // Query Tickets with search keyword
            $ticketsQuery = Ticket::with(['ticketCategory', 'assignedUser', 'client'])
            ->where('assigned_to', $user->id);
            if ($searchQuery) {
                $ticketsQuery->where(function ($query) use ($searchQuery) {
                    $query->where('status', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('subject', 'LIKE', '%' . $searchQuery . '%');
                });
            }
            // Retrieve the paginated Tickets
            $tickets = $ticketsQuery->paginate(10);
            $ticketCategories = TicketCategory::all();

            return view('crm.crud.my-tickets.index', compact('tickets', 'ticketCategories'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-my-tickets')) {
            $ticketCategories = TicketCategory::all();
            $ticketCategories = TicketCategory::all();
            $clients = User::whereHasRole(['client'])->get();
            $assignedUsers = User::whereHasRole(['supervisor', 'manager'])->get();
            return view('crm.crud.my-tickets.create', compact('ticketCategories', 'assignedUsers', 'clients'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $request->validate([
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'priority' => 'required|in:low,medium,high',
            'subject' => 'required|string',
            'message' => 'required|string',
            'status' => 'required|in:Answered,Pending',
        ]);

        // Add the currently logged-in user as the assigned user
        $request->merge(['assigned_to' => $user]);

        Ticket::create($request->all());
        notify()->success('Ticket Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        if (Auth::user()->hasPermission('read-my-tickets')) {
            // Make sure the ticket is assigned to the currently logged-in user
            if ($ticket->assigned_to === Auth::id()) {
                return view('crm.crud.my-tickets.show', compact('ticket'));
            } else {
                abort(403, 'Unauthorized Access');
            }
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $my_ticket)
    {
        if (Auth::user()->hasPermission('update-my-tickets')) {
            $ticket = $my_ticket;
            $ticketCategories = TicketCategory::all();
            $clients = User::whereHasRole(['client'])->get();
            $assignedUsers = User::whereHasRole(['supervisor', 'manager'])->get();
            return view('crm.crud.my-tickets.edit', compact('ticket', 'ticketCategories', 'clients', 'assignedUsers'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $my_ticket)
    {
        $ticket = $my_ticket;
        $user = Auth::user()->id;
        $request->validate([
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'priority' => 'required|in:low,medium,high',
            'subject' => 'required|string',
            'message' => 'required|string',
            'status' => 'required|in:Answered,Pending',
        ]);

        // Make sure the ticket is assigned to the currently logged-in user
        if ($ticket->assigned_to === $user) {
            $ticket->update($request->all());
            notify()->success('Ticket Updated');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $my_ticket)
    {
        if (Auth::user()->hasPermission('delete-my-tickets')) {
            $ticket =$my_ticket;
            if ($ticket->assigned_to === Auth::id()) {
                $ticket->delete();
                notify()->success('Ticket has been deleted');
                return redirect()->back();
            } else {
                abort(403, 'Unauthorized Access');
            }
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
