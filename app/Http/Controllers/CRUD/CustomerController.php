<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use App\Models\Role;
use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\ContactMethod;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\Ticket;
use App\Models\TicketCategory;

class CustomerController extends Controller
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
        if (Auth::user()->hasPermission('manage-customer')) {
            
            $searchQuery = $request->input('search');
            $customersQuery = Customer::with(['lead', 'user']);
            if ($searchQuery) {
                $customersQuery->where(function ($query) use ($searchQuery) {
                    // Search by lead ID, lead full name, lead phone, and lead email
                    $query->whereHas('lead', function ($leadQuery) use ($searchQuery) {
                        $leadQuery->where('id', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('name', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('city', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('state', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('zip', 'LIKE', '%' . $searchQuery . '%');
                    });
                });
            }
            $customers = $customersQuery->paginate(10);
            return view('crm.crud.customers.index', compact('customers'));
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-customer')) {
            $leads = Lead::all();
            $users = User::all();
            return view('crm.crud.customers.create', compact('leads', 'users'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'lead_id' => 'required|exists:leads,id',
    //         'user_id' => 'required|exists:users,id',
    //     ]);

    //     $existingCustomer = Customer::where('lead_id', $request->lead_id)->first();

    //     if ($existingCustomer) {
    //         notify()->error('A Customer with that Lead ID already exists');
    //         return redirect()->back();
    //     }

    //     Customer::create($request->all());
    //     notify()->success('Customer Created');
    //     return redirect($this->previousUrl);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'user_password' => 'nullable|string|min:6',
        ]);

        // Retrieve the lead's information
        $lead = Lead::findOrFail($request->lead_id);

        // Check if a user already exists with the lead's email
        $existingUser = User::where('email', $lead->email)->first();

        $generatedPassword = null;
        if (!$existingUser) {
            // If user_password is provided, use it. Otherwise generate a random 8-char secure password.
            if ($request->filled('user_password')) {
                $password = $request->user_password;
            } else {
                $password = Str::random(8);
                $generatedPassword = $password;
            }

            $newUser = User::create([
                'name' => $lead->name,
                'email' => $lead->email,
                'password' => Hash::make($password),
            ]);

            // Attach the "client" role to the user
            $clientRole = Role::where('name', 'client')->first();
            if ($clientRole) {
                $newUser->roles()->attach($clientRole);
            }
        } else {
            // A user with the lead's email already exists
            notify()->error('A User with that Lead Email already exists');
        }

        // Create the customer with the lead ID
        Customer::create([
            'lead_id' => $request->lead_id,
            'user_id' => $existingUser ? $existingUser->id : $newUser->id,
        ]);

        if ($generatedPassword) {
            session()->flash('generated_password', $generatedPassword);
            notify()->success("Customer Created Successfully");
        } else {
            notify()->success('Customer Created Successfully');
        }
        
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        if (Auth::user()->hasPermission('read-customer')) {
            $leadId = $customer->lead_id;
            $customerId = $customer->id;
            $invoices = Invoice::where('lead_id', $leadId)->paginate(5);
            $payments = Payment::where('customer_id', $customerId)->paginate(5);
            $projects = Project::where('customer_id', $customerId)->paginate(5);
            $activities = Activity::where('customer_id', $customerId)->paginate(5);
            $activityTypes = ActivityType::all();
            $contactMethods = ContactMethod::all();
            $projectTypes = ProjectType::all();
            $projectStatuses = ProjectStatus::all();
            $paymentMethods = PaymentMethod::all();
            $paymentStatuses = PaymentStatus::all();
            return view('crm.crud.customers.show', compact('invoices', 'payments', 'projectTypes', 'paymentMethods', 'paymentStatuses', 'projectStatuses', 'projects', 'customer', 'contactMethods', 'activities', 'activityTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        if (Auth::user()->hasPermission('update-customer')) {
            $leads = Lead::all();
            $users = User::all();
            return view('crm.crud.customers.edit', compact('leads', 'users', 'customer'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Customer $customer)
    // {
    //     $request->validate([
    //         'lead_id' => 'required|exists:leads,id',
    //         'user_id' => 'required|exists:users,id',
    //     ]);

    //     $customer->update($request->all());
    //     notify()->success('Customer Updated');
    //     return redirect($this->previousUrl);
    // }

    // public function update(Request $request, Customer $customer)
    // {
    //     $request->validate([
    //         'lead_id' => 'required|exists:leads,id',
    //         'user_password' => 'nullable|min:6',
    //     ]);

    //     // Retrieve the lead's information
    //     $lead = Lead::findOrFail($request->lead_id);

    //     // Update the customer's lead ID
    //     $customer->update([
    //         'lead_id' => $request->lead_id,
    //     ]);

    //     // Check if a user already exists with the lead's email
    //     $existingUser = User::where('email', $lead->email)->first();

    //     if (!$existingUser) {
    //         // If a new password is provided, update the user's password
    //         if ($request->has('user_password')) {
    //             $customer->user->update([
    //                 'password' => Hash::make($request->user_password),
    //             ]);
    //         }

    //         // If the user is assigned to the customer, update the user's name and email
    //         if ($customer->user) {
    //             $customer->user->update([
    //                 'name' => $lead->name,
    //                 'email' => $lead->email,
    //             ]);
    //         }

    //         notify()->success('User Updated and Customer Updated');
    //     } else {
    //         // A user with the lead's email already exists
    //         notify()->error('A User with that Lead Email already exists');
    //     }

    //     return redirect($this->previousUrl);
    // }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'user_password' => 'nullable|string|min:6',
        ]);

        // Retrieve the lead's information
        $lead = Lead::findOrFail($request->lead_id);

        // Update the customer's lead ID
        $customer->update([
            'lead_id' => $request->lead_id,
        ]);

        if ($customer->user) {
            // Update the name and email to stay in sync with the Lead
            $customer->user->update([
                'name' => $lead->name,
                'email' => $lead->email,
            ]);

            // Only update password if admin has entered one
            if ($request->filled('user_password')) {
                $customer->user->update([
                    'password' => Hash::make($request->user_password),
                ]);
            }

            notify()->success('Customer Updated Successfully');
        } else {
            notify()->error('No User found for this Customer');
        }

        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     * Deletes all related records first to avoid foreign key constraint violations.
     */
    public function destroy(Customer $customer)
    {
        if (Auth::user()->hasPermission('delete-customer')) {
            // Delete related records in correct order (child tables first)
            $customer->payments()->delete();
            $customer->activities()->delete();
            $customer->projects()->delete();

            $customer->delete();
            notify()->success('Customer Deleted');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    // public function destroy(Customer $customer)
    // {
    //     if (Auth::user()->hasPermission('delete-customer')) {
    //         // Retrieve the associated user
    //         $user = $customer->user;

    //         if ($user) {
    //             // Detach the "client" role
    //             $clientRole = Role::where('name', 'client')->first();
    //             if ($clientRole) {
    //                 $user->roles()->detach($clientRole);
    //             }

    //             // Delete the user
    //             $user->delete();
    //         }

    //         // Delete the customer
    //         $customer->delete();

    //         notify()->success('Customer Deleted');
    //         return redirect()->route('crm.crud.customers.index');
    //     } else {
    //         abort(403, 'Unauthorized Access');
    //     }
    // }

    public function myInvoices()
    {
        if (Auth::user()->hasPermission('my-invoices')) {
            $authId = Auth::user()->id;
            $customer = Customer::where('user_id', $authId)->first();
            $leadId = $customer->lead->id;
            $invoices = Invoice::where('lead_id', $leadId)->paginate(10);
            return view('crm.clients.invoices', compact('invoices'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function myProjects()
    {
        if (Auth::user()->hasPermission('my-projects')) {
            $authId = Auth::user()->id;
            $customer = Customer::where('user_id', $authId)->first();
            $projects = $customer->projects()->paginate(10);
            return view('crm.clients.projects', compact('projects'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function myProjectShow($id)
    {
        if (Auth::user()->hasPermission('my-projects')) {
            $authId = Auth::user()->id;
            $customer = Customer::where('user_id', $authId)->first();

            if (!$customer) {
                abort(404, 'Customer profile not found.');
            }

            $project = Project::with([
                'projectType',
                'projectStatus',
                'assignedTo',
                'activities.activityType',
                'inventories.inventoryType',
                'inventories.inventoryStatus',
                'payments.paymentStatus',
                'attendance.employee',
                'attendance.attendanceStatus'
            ])->where('id', $id)
              ->where('customer_id', $customer->id)
              ->firstOrFail();

            $activities = $project->activities->sortByDesc('created_at');
            $attendance = $project->attendance->sortByDesc('date');
            $inventories = $project->inventories;
            $payments = $project->payments->sortByDesc('created_at');

            return view('crm.clients.project_show', compact('project', 'activities', 'attendance', 'inventories', 'payments'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function myPayments()
    {
        if (Auth::user()->hasPermission('my-payments')) {
            $authId = Auth::user()->id;
            $customer = Customer::where('user_id', $authId)->first();
            $payments = $customer->payments()->paginate(10);
            return view('crm.clients.payments', compact('payments'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function myTickets()
    {
        if (Auth::user()->hasPermission('my-tickets')) {
            $authId = Auth::user()->id;
            $tickets = Ticket::where('client_id', $authId)->paginate(10);
            $ticketCategories = TicketCategory::all();
            return view('crm.clients.tickets', compact('tickets', 'authId', 'ticketCategories'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function myInvoiceShow($id)
    {
        $authId = Auth::user()->id;
        $customer = Customer::where('user_id', $authId)->firstOrFail();
        $invoice = Invoice::with('items', 'lead', 'invoiceType', 'invoiceStatus')
            ->where('id', $id)
            ->where('lead_id', $customer->lead_id)
            ->firstOrFail();
        return view('crm.crud.invoices.show', compact('invoice'));
    }

    public function myInvoicePrint($id)
    {
        $authId = Auth::user()->id;
        $customer = Customer::where('user_id', $authId)->firstOrFail();
        $invoice = Invoice::with('items', 'lead')
            ->where('id', $id)
            ->where('lead_id', $customer->lead_id)
            ->firstOrFail();
        return view('crm.crud.invoices.print', compact('invoice'));
    }

    public function myProfile()
    {
        $authId = Auth::user()->id;
        $customer = Customer::with('lead', 'user', 'projects', 'payments')->where('user_id', $authId)->firstOrFail();
        return view('crm.clients.profile', compact('customer'));
    }

    public function myProfileUpdate(Request $request)
    {
        $authId = Auth::user()->id;
        $customer = Customer::where('user_id', $authId)->firstOrFail();
        $request->validate([
            'phone' => 'nullable|string',
            'alternate_phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
            'company_name' => 'nullable|string',
            'gstin' => 'nullable|string',
        ]);
        $customer->update($request->only(['phone', 'alternate_phone', 'address', 'city', 'state', 'zip', 'company_name', 'gstin']));
        if ($request->has('name') && $customer->user) {
            $customer->user->update(['name' => $request->name]);
        }
        notify()->success('Profile updated successfully');
        return redirect()->route('myProfile');
    }

    public function createTicket()
    {
        $ticketCategories = TicketCategory::all();
        return view('crm.clients.create-ticket', compact('ticketCategories'));
    }

    public function storeTicket(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ticket_category_id' => 'required|exists:ticket_categories,id',
        ]);
        Ticket::create([
            'subject' => $request->title,
            'message' => $request->description,
            'client_id' => Auth::user()->id,
            'ticket_category_id' => $request->ticket_category_id,
            'status' => 'Pending',
            'priority' => 'medium',
        ]);
        notify()->success('Ticket created successfully. We will get back to you soon.');
        return redirect()->route('myTickets');
    }
}
