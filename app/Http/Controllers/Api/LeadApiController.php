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
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'source' => 'nullable|string',
            'status' => 'nullable|string',
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
            'company_id' => $request->company_id ?? 1, // Protect HomeGlazer Org (ID: 1)
            'lead_source_id' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data recieved successfully',
            'lead_id' => $lead->id
        ], 201);
    }
}
