<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AttachmentRequest;
use App\Attachment;
use App\Employee;
use App\Storage;

class AttachmentController extends Controller
{
    public function index(Employee $employee)
    {
        $emp_name = $employee->name;
        $emp_id = $employee->id;
        $attachments = Attachment::with('employee')->where('employee_id', '=', $emp_id)->get();

        return view('attachments.index', compact('attachments', 'emp_name', 'emp_id'));
    }

    public function create(Employee $employee)
    {
        $attachment = new Attachment;
        $emp_id = $employee->id;
        $attachment->employee_id = $emp_id;

        return view('attachments.create',compact('attachment', 'employee'));
    }

    public function store(AttachmentRequest $request)
    {
        $emp_id = $request->employee_id;
        $attachments = Attachment::with('employee')->where('employee_id', '=', $emp_id)->get();
        $request->validate([
            'type' => 'required',
            'filename' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
        ]);

        if ($request->hasFile('filename')) {
            if ($request->file('filename')->isValid()) {
	            $attachment = new Attachment;
	            $attachment->user_id = auth()->user()->id;
	            $attachment->employee_id = $emp_id;
	            $attachment->filename = time()."_" .$request->file('filename')->getClientOriginalName();
	            $attachment->extension = $request->file('filename')->extension();
	            $attachment->filesize = $request->file('filename')->getClientSize();
	            $attachment->type = $request->type;
	            $attachment->location = $request->file('filename');
	            $request->file('filename')->move(public_path('files/'), $attachment->filename);
            }
        }

        $attachmentParms = $attachment->toArray();
        $changes = 'Attachment uploaded by ' . auth()->user()->name;
        $attachment->save();
        $attachment = $attachment->latest()->first();
        $this->logCreatedActivity($attachment, $changes ,$attachmentParms);

        return redirect('/attachments/'. $emp_id)->with('success', 'Attachment has been added Successfully');
    }

    public function edit($id)
    {
        $attachment = Attachment::findOrFail($id);

        return view('attachments.edit', compact('attachment'));
    }

    public function update(AttachmentRequest $request, $id)
    {
      	$attachment = Attachment::findOrFail($id);
        $emp_id = $request->employee_id;
        $request->validate([
            'filename' => 'mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
        ]);

        if ($request->hasFile('filename')) {
            if ($request->file('filename')->isValid()) {
                if (!empty($allowance->filename)) {
	                $delete_file = public_path("files/{$old_file->filename}");
	                unlink($delete_file);
                }            	

	            $attachment->user_id = auth()->user()->id;
	            $attachment->employee_id = $emp_id;
	            $attachment->filename = time()."_" .$request->file('filename')->getClientOriginalName();
	            $attachment->extension = $request->file('filename')->extension();
	            $attachment->filesize = $request->file('filename')->getClientSize();
	            $attachment->type = $request->type;
	            $attachment->location = $request->file('filename');
	            $request->file('filename')->move(public_path('files/'), $attachment->filename);
            }
        }

        $beforeUpdateValues = $attachment->toArray();
        $attachment->fill($request->all())->employee();
        $attachment->save();
        $afterUpdateValues = $attachment->getChanges();
        $this->logUpdatedActivity($attachment,$beforeUpdateValues,$afterUpdateValues);

        return redirect('/attachments/'. $emp_id)->with('success', 'Attachment has been updated Successfully');
    }

    public function getDownload($attachment)
    {
        $attachment = Attachment::findOrFail($attachment);
        $filename = $attachment->filename;
        
        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $attachment = Attachment::findOrFail($id);
        $emp_id = $attachment->employee_id;
        $delete_filename = public_path("/files/{$attachment->filename}");
        if (!empty($attachment->filename)) {
            unlink($delete_filename);
        }
        $attachment->delete();

       	return redirect('/attachments/'. $emp_id)->with('success', 'Attachment has been deleted Successfully');
    }
}
