<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillStatus;
use App\Models\BillType;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Vendor;
use App\Models\VendorUser;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorUserController extends Controller
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
        if (Auth::user()->hasPermission('manage-vendor-user')) {
            $searchQuery = $request->input('search');
            $vendorUserQuery = VendorUser::with(['vendor', 'user']);
            if ($searchQuery) {
                $vendorUserQuery->where(function ($query) use ($searchQuery) {
                    $query->whereHas('vendor', function ($vendorQuery) use ($searchQuery) {
                        $vendorQuery->where('id', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('name', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('address', 'LIKE', '%' . $searchQuery . '%');
                    });
                });
            }
            $vendorUsers = $vendorUserQuery->paginate(10);
            return view('crm.crud.vendor-users.index', compact('vendorUsers'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-vendor-user')):
            $vendors = Vendor::all();
            $users = User::all();
            return view('crm.crud.vendor-users.create', compact('vendors', 'users'));
        else:
            abort(403, 'Unauthorized Access');
        endif;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'user_password' => 'required|min:6',
        ]);

        // Retrieve the vendor's information
        $vendor = Vendor::findOrFail($request->vendor_id);

        // Check if a user already exists with the vendor's email
        $existingUser = User::where('email', $vendor->email)->first();

        if (!$existingUser) {
            // Create a new user with the vendor's name and email
            $newUser = User::create([
                'name' => $vendor->name,
                'email' => $vendor->email,
                'password' => Hash::make($request->user_password),
            ]);

            // Attach the "client" role to the user
            $vendorRole = Role::where('name', 'vendor')->first();
            if ($vendorRole) {
                $newUser->roles()->attach($vendorRole);
            }

            notify()->success('User Created and Assigned to vendor');
        } else {
            // A user with the vendors's email already exists
            notify()->error('A User with that vendor Email already exists');
        }

        // Create the vendorUser with the vendor ID
        VendorUser::create([
            'vendor_id' => $request->vendor_id,
            'user_id' => $existingUser ? $existingUser->id : $newUser->id,
        ]);

        notify()->success('vendor User Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(VendorUser $vendorUser)
    {
        if (Auth::user()->hasPermission('read-vendor-user')) {
            return view('crm.crud.vendor-users.show', compact('vendorUser'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorUser $vendorUser)
    {
        if (Auth::user()->hasPermission('update-vendor-user')) {
            $vendors = Vendor::all();
            $users = User::all();
            return view('crm.crud.vendor-users.edit', compact('vendors', 'users', 'vendorUser'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, vendorUser $vendorUser)
    // {
    //     $request->validate([
    //         'vendor_id' => 'required|exists:vendors,id',
    //         'user_password' => 'nullable|min:6',
    //     ]);

    //     // Retrieve the vendor's information
    //     $vendor = vendor::findOrFail($request->vendor_id);

    //     // Update the vendor User's vendor ID
    //     $vendorUser->update([
    //         'vendor_id' => $request->vendor_id,
    //     ]);

    //     // Check if a user already exists with the vendor User's email
    //     $existingUser = User::where('email', $vendor->email)->first();

    //     if (!$existingUser) {
    //         // If a new password is provided, update the user's password
    //         if ($request->has('user_password')) {
    //             $vendorUser->user->update([
    //                 'password' => Hash::make($request->user_password),
    //             ]);
    //         }

    //         // If the user is assigned to the vendor User, update the user's name and email
    //         if ($vendorUser->user) {
    //             $vendorUser->user->update([
    //                 'name' => $vendor->name,
    //                 'email' => $vendor->email,
    //             ]);
    //         }

    //         notify()->success('User Updated and vendor User Information Updated');
    //     } else {
    //         // A user with the vendor's email already exists
    //         notify()->error('A User with that vendor Email already exists');
    //     }

    //     return redirect($this->previousUrl);
    // }

    public function update(Request $request, VendorUser $vendorUser)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'user_password' => 'nullable|min:6',
        ]);

        // Retrieve the vendor's information
        $vendor = Vendor::findOrFail($request->vendor_id);

        // Update the vendor User's vendor ID
        $vendorUser->update([
            'vendor_id' => $request->vendor_id,
        ]);

        if ($vendorUser->user) {
            // If the user exists, update the name and email
            $vendorUser->user->update([
                'name' => $vendor->name,
                'email' => $vendor->email,
            ]);

            // Update the password only if provided
            if ($request->has('user_password')) {
                $vendorUser->user->update([
                    'password' => Hash::make($request->user_password),
                ]);
            }

            notify()->success('User Updated and vendor User Information Updated');
        } else {
            notify()->error('No User found for this vendor');
        }

        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorUser $vendorUser)
    {
        if (Auth::user()->hasPermission('delete-vendor-user')) {
            $vendorUser->delete();
            notify()->success('Customer Deleted');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }        
    }

    public function vbills()
    {
        if (Auth::user()->hasPermission('vendor-bills')) {
            $userId = Auth::user()->id;
            $vendorUser = VendorUser::where('user_id', $userId)->first();
            $vendorId = $vendorUser->vendor_id;
            $vendor = Vendor::where('id', $vendorId)->first();
            $bills = $vendor->bills()->latest()->paginate(8);
            $billTypes = BillType::all();
            $billStatuses = BillStatus::all();
            return view('crm.vendors.bills', compact('bills', 'billTypes', 'billStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function vInventories()
    {
        if (Auth::user()->hasPermission('vendor-inventories')) {
            $userId = Auth::user()->id;
            $vendorUser = VendorUser::where('user_id', $userId)->first();
            $vendorId = $vendorUser->vendor_id;
            $vendor = Vendor::where('id', $vendorId)->first();
            $inventories = $vendor->inventories()->latest()->paginate(10);
            return view('crm.vendors.inventories', compact('inventories'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
