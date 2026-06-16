<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-skill')) {
            $skills = Skill::paginate(10);
            return view('crm.fields.skills.index', compact('skills'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-skill')) {
            return view('crm.fields.skills.create');
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
            'name' => 'required|unique:skills',
        ]);

        Skill::create([
            'name' => $request->name,
        ]);

        notify()->success('Skill has been created');
        return redirect()->route('skills.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        if (Auth::user()->hasPermission('read-skill')) {
            return view('crm.fields.skills.show', compact('skill'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        if (Auth::user()->hasPermission('update-skill')) {
            return view('crm.fields.skills.edit', compact('skill'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|unique:skills,name,' . $skill->id,
        ]);

        $skill->update($request->all());

        notify()->success('Skill Updated');
        return redirect()->route('skills.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        if (Auth::user()->hasPermission('delete-skill')) {
            $skill->delete();
            notify()->success('Skill Deleted');
            return redirect()->route('skills.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
