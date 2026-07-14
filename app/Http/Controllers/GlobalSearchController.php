<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class GlobalSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return redirect()->back()->with('error', 'Please enter a search term.');
        }

        $companyId = Auth::user()->company_id;

        // Search Leads
        $leads = Lead::where('company_id', $companyId)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('phone', 'like', "%{$query}%");
            })->take(10)->get();

        // Search Projects
        $projects = Project::where('company_id', $companyId)
            ->where('name', 'like', "%{$query}%")
            ->take(10)->get();

        // Search Customers
        $customers = Customer::whereHas('lead', function($q) use ($companyId, $query) {
                $q->where('company_id', $companyId)
                  ->where(function($q2) use ($query) {
                      $q2->where('name', 'like', "%{$query}%")
                         ->orWhere('email', 'like', "%{$query}%")
                         ->orWhere('phone', 'like', "%{$query}%");
                  });
            })->take(10)->get();

        // Search Tasks
        $tasks = Task::where('company_id', $companyId)
            ->where('title', 'like', "%{$query}%")
            ->take(10)->get();

        return view('crm.search.results', compact('query', 'leads', 'projects', 'customers', 'tasks'));
    }
}
