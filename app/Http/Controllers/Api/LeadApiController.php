<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Validator;

class LeadApiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email',
            'phone' => 'required|string|min:10|unique:leads,phone',
            'company' => 'nullable|string|max:255',
            'source' => 'required|string|in:website,referral,cold_call,email,social,other',
            'status' => 'required|string|in:new,contacted,qualified,converted,lost',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Valid name and email are required',
                'errors' => $validator->errors()
            ], 422);
        }

        $lead = Lead::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? null,
            'lead_source_id' => 1, // Corrected from leads_source_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data recieved successfully',
            'lead_id' => $lead->id
        ], 201);
    }
}
