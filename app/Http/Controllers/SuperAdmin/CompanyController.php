<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     */
    public function index()
    {
        $companies = Company::withCount('users')->latest()->get();
        return view('superadmin.companies.index', compact('companies'));
    }

    /**
     * Toggle the status of a company (active/blocked).
     */
    public function toggleStatus(Company $company)
    {
        if ($company->status === 'active') {
            $company->status = 'blocked';
            $company->save();
            return redirect()->back()->with('success', 'Company has been blocked. They can no longer access the CRM.');
        } else {
            $company->status = 'active';
            $company->save();
            return redirect()->back()->with('success', 'Company has been activated.');
        }
    }
}
