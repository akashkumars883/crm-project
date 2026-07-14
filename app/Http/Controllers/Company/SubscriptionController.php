<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        $currentSubscription = $company->subscription;
        $plans = SubscriptionPlan::where('is_active', true)->get();
        
        return view('company.subscription.index', compact('currentSubscription', 'plans'));
    }

    public function checkout(Request $request)
    {
        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $company = Auth::user()->company;

        if ($plan->price == 0) {
            // Free plan logic
            Subscription::updateOrCreate(
                ['company_id' => $company->id],
                [
                    'subscription_plan_id' => $plan->id,
                    'status' => 'active',
                    'payment_method' => 'none',
                    'starts_at' => Carbon::now(),
                    'ends_at' => null // Lifetime free or arbitrary limit
                ]
            );
            notify()->success('Successfully subscribed to Free plan.');
            return redirect()->route('company.subscription.index');
        }

        // Initialize Razorpay
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // Create an order
        $orderData = [
            'receipt'         => 'rcptid_sub_' . $company->id . '_' . time(),
            'amount'          => $plan->price * 100, // Amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        try {
            $razorpayOrder = $api->order->create($orderData);
        } catch (\Exception $e) {
            notify()->error('Error creating Razorpay Order: ' . $e->getMessage());
            return redirect()->back();
        }

        return view('company.subscription.checkout', compact('plan', 'razorpayOrder'));
    }

    public function verify(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        try {
            $attributes = array(
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            );
            
            $api->utility->verifyPaymentSignature($attributes);
        } catch(\Razorpay\Api\Errors\SignatureVerificationError $e) {
            notify()->error('Payment Failed: ' . $e->getMessage());
            return redirect()->route('company.subscription.index');
        }

        // Payment successful
        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $company = Auth::user()->company;

        Subscription::updateOrCreate(
            ['company_id' => $company->id],
            [
                'subscription_plan_id' => $plan->id,
                'status' => 'active',
                'payment_method' => 'razorpay',
                'transaction_id' => $request->razorpay_payment_id,
                'starts_at' => Carbon::now(),
                'ends_at' => Carbon::now()->addYear() // Assuming annual plan for now
            ]
        );

        notify()->success('Payment successful. Subscription upgraded to ' . $plan->name);
        return redirect()->route('company.subscription.index');
    }
}
