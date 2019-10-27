<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QualificationRequest;
use App\Qualification;
use App\Employee;
use App\UploadFile;

class QualificationController extends Controller
{
    public function index(Employee $employee)
    {
        $emp_name = $employee->name;
        $emp_id = $employee->id;
        $qualifications = Qualification::with('employee')->where('employee_id', '=', $emp_id)->get();

        return view('qualifications.index', compact('qualifications', 'emp_name', 'emp_id'));
    }

    public function create(Employee $employee)
    {
        $qualification = new Qualification;
        $emp_id = $employee->id;
        $qualification->employee_id = $emp_id;

        return view('qualifications.create',compact('qualification', 'employee'));
    }

    public function store(QualificationRequest $request)
    {
        $emp_id = $request->employee_id;
        $emp_name = $request->name;
        $qualifications = Qualification::with('employee')->where('employee_id', '=', $emp_id)->get();
        $qualification = new Qualification;
        $qualification->fill($request->all());

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                if (!empty($qualification->filename)) {
                    $delete_files = public_path("files/{$qualification->filename}");
                    unlink($delete_files);
                }
                $qualification->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $qualification->filename);
            }
        }

        $qualificationParms = $qualification->toArray();
        $changes = 'Qualification created by ' . auth()->user()->name;
        $qualification->save();
        $qualification = $qualification->latest()->first();
        $this->logCreatedActivity($qualification, $changes ,$qualificationParms);

        return redirect('/qualifications/'. $emp_id)->with('success', 'Qualification has been added Successfully');
    }

    public function edit($id)
    {
        $qualification = Qualification::findOrFail($id);
        $emp_id = $qualification->employee_id;

        return view('qualifications.edit', compact('qualification', 'emp_id'));
    }

    public function update(QualificationRequest $request, $id)
    {
      	$qualification = Qualification::findOrFail($id);
        $emp_id = $request->employee_id;

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                if (!empty($qualification->filename)) {
                    $delete_files = public_path("files/{$qualification->filename}");
                    unlink($delete_files);
                }
                $qualification->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $qualification->filename);
            }
        }

        $beforeUpdateValues = $qualification->toArray();
        $qualification->fill($request->all())->employee();
        $qualification->save();
        $afterUpdateValues = $qualification->getChanges();
        $this->logUpdatedActivity($qualification,$beforeUpdateValues,$afterUpdateValues);

        return redirect('/qualifications/'. $emp_id)->with('success', 'Qualification has been updated Successfully');
    }

    public function getDownload($qualification)
    {
        $qualification = Qualification::findOrFail($qualification);
        $filename = $qualification->filename;
        
        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $qualification = Qualification::findOrFail($id);
        $emp_id = $qualification->employee_id;
        if (!empty($qualification->filename)) {
            $delete_files = public_path("files/{$qualification->filename}");
            unlink($delete_files);
        }
        $qualification->delete();

       	return redirect('/qualifications/'. $emp_id)->with('success', 'Qualification has been deleted Successfully');
    }
}
