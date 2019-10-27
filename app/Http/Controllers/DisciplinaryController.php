<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DisciplinaryRequest;
use App\Employee;
use App\Disciplinary;

class DisciplinaryController extends Controller
{
    public function index(Employee $employee)
    {
        $emp_name = $employee->name;
        $emp_id = $employee->id;
        $disciplinaries = Disciplinary::with('employee')->where('employee_id', '=', $emp_id)->get();

        return view('disciplinaries.index', compact('disciplinaries', 'emp_name', 'emp_id'));
    }

    public function create(Employee $employee)
    {
        $disciplinary = new Disciplinary;
        $emp_id = $employee->id;
        $disciplinary->employee_id = $emp_id;

        return view('disciplinaries.create',compact('disciplinary', 'employee'));
    }

    public function store(DisciplinaryRequest $request)
    {
        $emp_id = $request->employee_id;
        $emp_name = $request->name;
        $disciplinaries = Disciplinary::with('employee')->where('employee_id', '=', $emp_id)->get();
        $disciplinary = new Disciplinary;
        $disciplinary->fill($request->all());

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($disciplinary->filename)) {
                    $delete_files = public_path("files/{$disciplinary->filename}");
                    unlink($delete_files);
                }
                $disciplinary->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $disciplinary->filename);
            }
        }

        $disciplinaryParms = $disciplinary->toArray();
        $changes = 'Disciplinary created by ' . auth()->user()->name;
        $disciplinary->save();
        $disciplinary = $disciplinary->latest()->first();
        $this->logCreatedActivity($disciplinary, $changes ,$disciplinaryParms);

  	    return redirect('/disciplinaries/'. $emp_id)->with('success', 'Disciplinary action has been added');
    }

    public function edit($id)
    {
        $disciplinary = Disciplinary::findOrFail($id);
        $emp_id = $disciplinary->employee_id;

        return view('disciplinaries.edit', compact('disciplinary', 'emp_id'));
    }

    public function update(DisciplinaryRequest $request, $id)
    {
      	$disciplinary = Disciplinary::findOrFail($id);
        $emp_id = $request->employee_id;

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($disciplinary->filename)) {
                    $delete_files = public_path("files/{$disciplinary->filename}");
                    unlink($delete_files);
                }
                $disciplinary->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $disciplinary->filename);
            }
        }

        $beforeUpdateValues = $disciplinary->toArray();
        $disciplinary->fill($request->all());
        $disciplinary->save();
        $afterUpdateValues = $disciplinary->getChanges();
        $this->logUpdatedActivity($disciplinary,$beforeUpdateValues,$afterUpdateValues);

      	return redirect('/disciplinaries/'. $emp_id)->with('success', 'Disciplinary action has been updated');
    }

    public function getDownload($disciplinary)
    {
        $disciplinary = Disciplinary::findOrFail($disciplinary);
        $filename = $disciplinary->filename;
        
        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $disciplinary = Disciplinary::findOrFail($id);
        $emp_id = $disciplinary->employee_id;
        if (!empty($disciplinary->filename)) {
            $delete_files = public_path("files/{$disciplinary->filename}");
            unlink($delete_files);
        }
        $disciplinary->delete();
     	
       	return redirect('/disciplinaries/'. $emp_id)->with('success', 'Disciplinary action has been deleted Successfully');
    }
}
