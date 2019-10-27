<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use App\UploadFile;
use App\Employee;
use Route;
use Move;
use Storage;
use DB;

class UploadController extends Controller
{
    public function uploadForm()
    {
        return view('uploads.form');
    }

    public function store(UploadRequest $request, $employee)
    {
        $old_file = UploadFile::with('employee')->where('employee_id', '=', $employee)->latest()->first();
        if ($request->file('filename')->isValid()) {
            if (!empty($old_file)) {
                $old_file_id = $old_file->id;
                $upload_file = UploadFile::findOrFail($old_file_id);
                $delete_file = public_path("files/{$old_file->filename}");
                unlink($delete_file);
            } else {
                $upload_file = new UploadFile;
            }

            $upload_file->user_id = auth()->user()->id;
            $upload_file->employee_id = $employee;
            $upload_file->filename = time()."_" .$request->file('filename')->getClientOriginalName();
            $upload_file->extension = $request->file('filename')->extension();
            $upload_file->filesize = $request->file('filename')->getClientSize();
            $upload_file->location = $request->file('filename');
            $request->file('filename')->move(public_path('files/'), $upload_file->filename);

            // Logs
            $upload_fileParms = $upload_file->toArray();
            $changes = $upload_file->filename. ' uploaded by '. auth()->user()->name;
            $upload_file->save();
            $upload_file = $upload_file->latest()->first();
            $this->logCreatedActivity($upload_file, $changes ,$upload_fileParms);
        }

        return back()->with('success', 'You have successfully upload documents.');
    }

    public function update(UploadRequest $request, $file)
    {
        $upload_files = UploadFile::findOrFail($file);
        $filename = $upload_files->filename;

        return back()->with('success', 'You have successfully upload documents.');
    }

    public function getDownload($file)
    {
        $upload_files = UploadFile::findOrFail($file);
        $filename = $upload_files->filename;
        
        return response()->download(public_path('files/'. $filename));
    }
}
        // $exists = Storage::disk('local')->exists($filename);
        // dd($exists);

        // if ($exists) {
        // } else {
        //     return back()->with('errors', 'You have successfully upload documents.');
        // }

    // public function search(Request $request)
    // {
    //     if ($request->hasfile('coa')) {
    //         if ($request->file('coa')->isValid()) {
    //             $upload_file = new UploadFile;
    //             $upload_file->user_id = auth()->user()->id;
    //             $upload_file->employee_id = $request->route('employee');
    //             $upload_file->type = $request->type;
    //             $upload_file->coa = $upload_file->employee_id. "_" .time(). "_" .$request->file('coa')->getClientOriginalName();
    //             $upload_file->extension = $request->file('coa')->extension();
    //             $upload_file->filesize = $request->file('coa')->getClientSize();
    //             $upload_file->location = $request->file('coa');

    //             $coa = $upload_file->coa;
    //             $request->file('coa')->move(public_path('files/'), $coa);
    //             $upload_file->save();
    //         }
    //     }

    //     if ($request->hasfile('nric_passport')) {
    //         if ($request->file('nric_passport')->isValid()) {
    //             $upload_file = new UploadFile;
    //             $upload_file->user_id = auth()->user()->id;
    //             $upload_file->employee_id = $request->route('employee');
    //             $upload_file->type = $request->type;
    //             $upload_file->nric_passport = $upload_file->employee_id. "_" .time(). "_" .$request->file('nric_passport')->getClientOriginalName();
    //             $upload_file->extension = $request->file('nric_passport')->extension();
    //             $upload_file->filesize = $request->file('nric_passport')->getClientSize();
    //             $upload_file->location = $request->file('nric_passport');

    //             $nric_passport = $upload_file->nric_passport;
    //             $request->file('nric_passport')->move(public_path('files/'), $nric_passport);
    //             $upload_file->save();
    //         }
    //     }
    // }
            // UploadFile::make($emp_files)->save($location);
            // toastr()->success('Documents has been saved successfully!');
            // flash()->success('Your file is currently being processed. You will be notified when done.');
            // UploadFile::dispatch($upload_file, $group)->onQueue('file-uploads');
        //     dispatch(new UploadFile($upload_file, $employee))->onQueue('file-uploads');
        // } else {
        //     flash()->error('There was a problem uploading your file. Please try again.');