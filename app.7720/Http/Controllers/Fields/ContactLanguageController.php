<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\ContactLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-contact-language')) {
            $contactLanguages = ContactLanguage::paginate(10);
            return view('crm.fields.contact-languages.index', compact('contactLanguages'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-contact-language')) {
            return view('crm.fields.contact-languages.create');
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
            'name' => 'required|unique:contact_languages',
        ]);

        ContactLanguage::create([
            'name' => $request->name,
        ]);

        notify()->success('Preferred Contact Language has been created');
        return redirect()->route('contact-languages.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactLanguage $contactLanguage)
    {
        if (Auth::user()->hasPermission('read-contact-language')) {
            return view('crm.fields.contact-languages.show', compact('contactLanguage'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactLanguage $contactLanguage)
    {
        if (Auth::user()->hasPermission('update-contact-language')) {
            return view('crm.fields.contact-languages.edit', compact('contactLanguage'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactLanguage $contactLanguage)
    {
        $request->validate([
            'name' => 'required|unique:contact_languages,name,' . $contactLanguage->id,
        ]);

        $contactLanguage->update($request->all());

        notify()->success('Preferred Contact Language Updated');
        return redirect()->route('contact-languages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactLanguage $contactLanguage)
    {
        if (Auth::user()->hasPermission('delete-contact-language')) {
            $contactLanguage->delete();
            notify()->success('Preferred Contact Language Deleted');
            return redirect()->route('contact-languages.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
