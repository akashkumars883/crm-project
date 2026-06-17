<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-company');
    }

    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            // Create the Company
            $company = Company::create([
                'name' => $request->company_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'plan' => 'free',
            ]);

            // Create the Admin User for this Company
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'company_id' => $company->id,
            ]);

            // Attach 'admin' role using Laratrust
            $user->addRole('admin');

            DB::commit();

            // Log the user in
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Your company has been registered successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }
    }
}
