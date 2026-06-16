<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Customer;
use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Project;
use App\Models\ContactMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ActivityController extends Controller
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
        if (Auth::user()->hasPermission('manage-activity')) {
            $chart_options = [
                'chart_title' => 'Activities by month',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Activity',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'date_format' => 'M',
                'chart_type' => 'bar',
            ];

            $chart1 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Activities by day',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Activity',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'date_format' => 'D',
                'chart_type' => 'bar',
            ];

            $chart2 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Activities by Type',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Activity',
                'relationship_name' => 'activityType',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart3 = new LaravelChart($chart_options);

            $searchQuery = $request->input('search');
            
            // Query activities with search keyword
            $activitiesQuery = Activity::with(['activityType', 'contactMethod',]);
            if ($searchQuery) {
                $activitiesQuery->where(function ($query) use ($searchQuery) {
                    $query->where('title', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchQuery . '%');
                });
            }
            // Retrieve the paginated activities
            $activities = $activitiesQuery->paginate(10);
            return view('crm.crud.activities.index', compact('activities', 'chart1', 'chart2', 'chart3'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-activity')) {
            $activityTypes = ActivityType::all();
            $leads = Lead::all();
            $customers = Customer::all();
            $projects = Project::all();
            $contactMethods = ContactMethod::all();
            return view('crm.crud.activities.create', compact('activityTypes', 'leads', 'customers', 'projects', 'contactMethods'));
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
            'activity_type_id' => 'nullable|exists:activity_types,id',
            'lead_id' => 'nullable|exists:leads,id',
            'customer_id' => 'nullable|exists:customers,id',
            'project_id' => 'nullable|exists:projects,id',
            'contact_method_id' => 'required|exists:contact_methods,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Activity::create($request->all());
        notify()->success('Activity Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        if (Auth::user()->hasPermission('read-activity')) {
            return view('crm.crud.activities.show', compact('activity'));
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        if (Auth::user()->hasPermission('update-lead')) {
            $activityTypes = ActivityType::all();
            $leads = Lead::all();
            $customers = Customer::all();
            $projects = Project::all();
            $contactMethods = ContactMethod::all();            
            return view('crm.crud.activities.edit', compact('activityTypes', 'leads', 'customers', 'projects', 'contactMethods', 'activity'));
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'activity_type_id' => 'nullable|exists:activity_types,id',
            'lead_id' => 'nullable|exists:leads,id',
            'customer_id' => 'nullable|exists:customers,id',
            'project_id' => 'nullable|exists:projects,id',
            'contact_method_id' => 'required|exists:contact_methods,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $activity->update($request->all());
        notify()->success('Activity Updatedd');
        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        if (Auth::user()->hasPermission('delete-activity')) {
            $activity->delete();
            notify()->success('Activity Deleted Successfully');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }
}
