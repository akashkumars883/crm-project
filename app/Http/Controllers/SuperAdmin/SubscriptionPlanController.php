<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = SubscriptionPlan::all();
        return view('superadmin.subscription_plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.subscription_plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_users' => 'required|integer|min:1',
            'max_customers' => 'required|integer|min:1',
            'max_projects' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        SubscriptionPlan::create($data);
        
        notify()->success('Subscription Plan Created Successfully');
        return redirect()->route('superadmin.subscription_plans.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('superadmin.subscription_plans.edit', compact('subscriptionPlan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_users' => 'required|integer|min:1',
            'max_customers' => 'required|integer|min:1',
            'max_projects' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        $subscriptionPlan->update($data);
        
        notify()->success('Subscription Plan Updated Successfully');
        return redirect()->route('superadmin.subscription_plans.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        // Don't delete if there are active subscriptions
        if (\App\Models\Subscription::where('subscription_plan_id', $subscriptionPlan->id)->exists()) {
            notify()->error('Cannot delete plan. There are companies subscribed to this plan.');
            return redirect()->back();
        }

        $subscriptionPlan->delete();
        notify()->success('Subscription Plan Deleted Successfully');
        return redirect()->route('superadmin.subscription_plans.index');
    }
}
