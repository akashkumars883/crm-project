<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Attachment;
use App\Models\AttachmentType;
use App\Models\Bill;
use App\Models\BillStatus;
use App\Models\BillType;
use App\Models\ContactMethod;
use App\Models\Customer;
use App\Models\User;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class MyProjectsController extends Controller
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
        if (Auth::user()->hasPermission('manage-assigned-projects')) {
            $user = Auth::user();
            $searchQuery = $request->input('search');
            
            // Query projects with search keyword
            $projectsQuery = Project::with(['projectStatus', 'projectType', 'customer', 'customer.lead'])
                ->where('assigned_to', $user->id);;
            if ($searchQuery) {
                $projectsQuery->where(function ($query) use ($searchQuery) {
                    $query->where('id', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhereHas('customer', function ($customerQuery) use ($searchQuery) {
                            $customerQuery->whereHas('lead', function ($leadQuery) use ($searchQuery) {
                                $leadQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                            });
                        })
                        ->orWhereHas('projectType', function ($typeQuery) use ($searchQuery) {
                            $typeQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('projectStatus', function ($statusQuery) use ($searchQuery) {
                            $statusQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        });
                });
            }

            $projects = $projectsQuery->paginate(10);
            
            return view('crm.crud.my-projects.index', compact('projects',));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-assigned-projects')) {
            $rolesToFetch = ['manager', 'supervisor'];
            $users = User::whereHas('roles', function ($query) use ($rolesToFetch) {
                $query->whereIn('name', $rolesToFetch);
            })->get();
            $customers = Customer::all();
            $projects = Project::all();
            $projectTypes =ProjectType::all();
            $projectStatuses = ProjectStatus::all();
            return view('crm.crud.my-projects.create', compact('projectTypes', 'users', 'projectStatuses', 'customers', 'projects', ));
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
            'project_type_id' => 'required|exists:project_types,id',
            'project_status_id' => 'required|exists:project_statuses,id',
            'customer_id' => 'required|exists:customers,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Project::create($request->all());
        notify()->success('Project Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        if (Auth::user()->hasPermission('read-assigned-projects')) {
            $projectId = $project->id;
            $payments = Payment::where('project_id', $projectId)->paginate(5);
            $bills = Bill::where('project_id', $projectId)->paginate(5);
            $activities = Activity::where('project_id', $projectId)->paginate(5);
            $attachments = Attachment::where('project_id', $projectId)->paginate(5);
            $activityTypes = ActivityType::all();
            $contactMethods = ContactMethod::all();
            $billTypes = BillType::all();
            $billStatuses = BillStatus::all();
            $paymentMethods = PaymentMethod::all();
            $inventories = Inventory::all();
            $employees = Employee::all();
            $paymentStatuses = PaymentStatus::all();
            $customers = Customer::all();
            $projects = Project::all();
            $attachmentTypes = AttachmentType::all();
            // $projectBills = $project->bills->sum('amount');
            return view('crm.crud.my-projects.show', compact('project', 'attachmentTypes', 'projects', 'customers', 'paymentStatuses', 'employees', 'inventories', 'paymentMethods', 'billStatuses', 'billTypes', 'activityTypes', 'contactMethods', 'attachments', 'activities', 'bills', 'payments'));
        } else {
            abort(403, 'Unauthorized Access');
        }       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if (Auth::user()->hasPermission('update-assigned-projects')) {
            $rolesToFetch = ['manager', 'supervisor'];
            $users = User::whereHas('roles', function ($query) use ($rolesToFetch) {
                $query->whereIn('name', $rolesToFetch);
            })->get();
            $projectTypes = ProjectType::all();
            $projectStatuses = ProjectStatus::all();
            $customers = Customer::all();
            return view('crm.crud.my-projects.edit', compact('projectTypes', 'users', 'projectStatuses', 'customers', 'project'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'project_status_id' => 'required|exists:project_statuses,id',
            'customer_id' => 'required|exists:customers,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project->update($request->all());
        notify()->success('Project Updated');
        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $my_project)
    {
        if (Auth::user()->hasPermission('delete-assigned-projects')) {
            $project->delete();
            notify()->success('Project Deleted Successfully');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }
}
