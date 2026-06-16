<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\AttachmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttachmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-attachment-type')) {
            $attachmentTypes = AttachmentType::paginate(10);
            return view('crm.fields.attachment-types.index', compact('attachmentTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-attachment-type')) {
            return view('crm.fields.attachment-types.create');
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
            'name' => 'required|unique:attachment_types',
        ]);

        AttachmentType::create([
            'name' => $request->name,
        ]);

        notify()->success('Attachment Type has been created');
        return redirect()->route('attachment-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttachmentType $attachmentType)
    {
        if (Auth::user()->hasPermission('read-attachment-type')) {
            return view('crm.fields.attachment-types.show', compact('attachmentType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttachmentType $attachmentType)
    {
        if (Auth::user()->hasPermission('update-attachment-type')) {
            return view('crm.fields.attachment-types.edit', compact('attachmentType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttachmentType $attachmentType)
    {
        $request->validate([
            'name' => 'required|unique:attachment_types,name,' . $attachmentType->id,
        ]);

        $attachmentType->update($request->all());

        notify()->success('Attachment Type Updated');
        return redirect()->route('attachment-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttachmentType $attachmentType)
    {
        if (Auth::user()->hasPermission('delete-attachment-type')) {
            $attachmentType->delete();
            notify()->success('Attachment Type Deleted');
            return redirect()->route('attachment-types.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
