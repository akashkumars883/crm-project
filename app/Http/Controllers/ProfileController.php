<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {
    // show profile page
    public function index() {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }
    
    // to update profile
    public function update(Request $request) {
        $user = Auth::user();

        // validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_ifsc' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            'upi_id' => 'nullable|string|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->bank_account_name = $request->bank_account_name;
        $user->bank_account_number = $request->bank_account_number;
        $user->bank_ifsc = $request->bank_ifsc;
        $user->bank_name = $request->bank_name;
        $user->bank_branch = $request->bank_branch;
        $user->upi_id = $request->upi_id;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storeOnCloudinary('avatars')->getSecurePath();
            $user->avatar = $path;
        }

        // update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        notify()->success('Profile Updated Successfully!');
        return redirect()->back();
    }
    
    // to show settings page 
    public function settings()
    {
        return view('profile.settings');
    }
}