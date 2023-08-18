<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\ContactMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-contact-method')) {
            $contactMethods = ContactMethod::paginate(10);
            return view('crm.fields.contact-methods.index', compact('contactMethods'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-contact-method')) {
            return view('crm.fields.contact-methods.create');
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
            'name' => 'required|unique:contact_methods',
        ]);

        ContactMethod::create([
            'name' => $request->name,
        ]);

        notify()->success('Preferred Contact Method has been created');
        return redirect()->route('contact-methods.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMethode $contactMethod)
    {
        if (Auth::user()->hasPermission('read-contact-method')) {
            return view('crm.fields.contact-methods.show', compact('contactMethods'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactMethod $contactMethod)
    {
        if (Auth::user()->hasPermission('update-contact-method')) {
            return view('crm.fields.contact-methods.edit', compact('contactMethod'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactMethod $contactMethod)
    {
        $request->validate([
            'name' => 'required|unique:contact_methods,name,' . $contactMethod->id,
        ]);

        $contactMethod->update($request->all());

        notify()->success('Preferred Contact Method Updated');
        return redirect()->route('contact-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMethod $contactMethod)
    {
        if (Auth::user()->hasPermission('delete-contact-method')) {
            $contactMethod->delete();
            notify()->success('Preferred Contact Method Deleted');
            return redirect()->route('contact-methods.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
