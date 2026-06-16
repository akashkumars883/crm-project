<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\AttachmentType;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
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
        if (Auth::user()->hasPermission('manage-attachment')) {
            $query = Attachment::with('project', 'attachmentType');

            if ($request->filled('attachment_type_id')) {
                $query->where('attachment_type_id', $request->input('attachment_type_id'));
            }

            if ($request->filled('project_id')) {
                $query->where('project_id', $request->input('project_id'));
            }

            $attachments = $query->paginate(10);
            $projects = Project::all();
            $attachmentTypes = AttachmentType::all();

            return view('crm.crud.attachments.index', compact('attachments', 'attachmentTypes', 'projects'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-attachment')) {
            $projects = Project::all();
            $attachmentTypes = AttachmentType::all();
            return view('crm.crud.attachments.create', compact('projects', 'attachmentTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'attachment_type_id' => 'required|exists:attachment_types,id',
            'project_id' => 'required|exists:projects,id',
            'images.*' => 'required|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        $attachmentTypeId = $validatedData['attachment_type_id'];
        $projectId = $validatedData['project_id'];
        
        $images = [];

        foreach ($request->file('images') as $image) {
            $extension = $image->getClientOriginalExtension();
            $filename = uniqid() . '.' . $extension;
            $path = "projects/{$projectId}/images";
            $saveFile = $image->storeAs($path, $filename, 'public');

            $images[] = $path . '/' . $filename; // Save the path in the format you want
        }

        Attachment::create([
            'attachment_type_id' => $attachmentTypeId,
            'project_id' => $projectId,
            'images' => $images,
        ]);
        notify()->success('Attachment Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        if (Auth::user()->hasPermission('read-attachment')) {
            # code...
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attachment $attachment)
    {
        if (Auth::user()->hasPermission('update-attachment')) {
            $attachmentTypes = AttachmentType::all();
            $projects = Project::all();
            return view('crm.crud.attachments.edit', compact('attachmentTypes', 'attachment', 'projects'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attachment $attachment)
    {
        $validatedData = $request->validate([
            'attachment_type_id' => 'required|exists:attachment_types,id',
            'project_id' => 'required|exists:projects,id',
            'images.*' => 'nullable|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);
        $attachmentTypeId = $validatedData['attachment_type_id'];
        $projectId = $validatedData['project_id'];
        $images = $attachment->images;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $path = "projects/{$projectId}/images";
                $saveFile = $image->storeAs($path, $filename, 'public');

                $images[] = $path . '/' . $filename; // Save the path in the format you want
            }
        }
        $attachment->update([
            'attachment_type_id' => $attachmentTypeId,
            'project_id' => $projectId,
            'images' => $images,
        ]);
        notify()->success('Attachment Updated');
        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        if (Auth::user()->hasPermission('delete-attachment')) {
            foreach ($attachment->images as $image) {
                Storage::delete("public/{$image}");
            }    
            $attachment->delete();
            notify()->success('Attachment Deleted');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
