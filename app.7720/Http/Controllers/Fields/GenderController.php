<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-gender')) {
            $genders = Gender::paginate(10);
            return view('crm.fields.genders.index', compact('genders'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-gender')) {
            return view('crm.fields.genders.create');
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
            'name' => 'required|unique:genders',
        ]);

        Gender::create([
            'name' => $request->name,
        ]);

        notify()->success('Gender has been created');
        return redirect()->route('genders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gender $gender)
    {
        if (Auth::user()->hasPermission('read-gender')) {
            return view('crm.fields.genders.show', compact('gender'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gender $gender)
    {
        if (Auth::user()->hasPermission('update-gender')) {
            return view('crm.fields.genders.edit', compact('gender'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gender $gender)
    {
        $request->validate([
            'name' => 'required|unique:genders,name,' . $gender->id,
        ]);

        $gender->update($request->all());

        notify()->success('Gender Updated');
        return redirect()->route('genders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gender $gender)
    {
        if (Auth::user()->hasPermission('delete-gender')) {
            $gender->delete();
            notify()->success('Gender Deleted');
            return redirect()->route('genders.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
