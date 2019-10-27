<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EquitmentRequest;
use App\Employee;
use App\Equitment;

class EquitmentController extends Controller
{
    public function index(Employee $employee)
    {
        $emp_name = $employee->name;
        $emp_id = $employee->id;
        $equitments = Equitment::with('employee')->where('employee_id', '=', $emp_id)->get();

        return view('equitments.index', compact('equitments', 'emp_name', 'emp_id'));
    }

    public function create(Employee $employee)
    {
        $equitment = new Equitment;
        $emp_id = $employee->id;
        $equitment->employee_id = $emp_id;

        return view('equitments.create',compact('equitment', 'employee'));
    }

    public function store(EquitmentRequest $request)
    {
        $emp_id = $request->employee_id;
        $emp_name = $request->name;
        $equitments = Equitment::with('employee')->where('employee_id', '=', $emp_id)->get();
        $equitment = Equitment::create($request->all());

        // Attachment
        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($equitment->filename)) {
                    $delete_files = public_path("files/{$equitment->filename}");
                    unlink($delete_files);
                }
                $equitment->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $equitment->filename);
            }
        }

        // Logs
        $equitmentParms = $equitment->toArray();
        $changes = 'Equitment created by ' . auth()->user()->name;
        $equitment->save();
        $equitment = $equitment->latest()->first();
        $this->logCreatedActivity($equitment, $changes ,$equitmentParms);

        return redirect('/equitments/'. $emp_id)->with('success', 'Equitment member has been added Successfully');
    }

    public function edit($id)
    {
        $equitment = Equitment::findOrFail($id);

        return view('equitments.edit', compact('equitment'));
    }

    public function update(EquitmentRequest $request, $id)
    {
      	$equitment = Equitment::findOrFail($id);
        $emp_id = $request->employee_id;

        // Attachment
        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($equitment->filename)) {
                    $delete_files = public_path("files/{$equitment->filename}");
                    unlink($delete_files);
                }
                $equitment->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $equitment->filename);
            }
        }

        // Logs
        $beforeUpdateValues = $equitment->toArray();
        $equitment->fill($request->all())->employee();
        $equitment->save();
        $afterUpdateValues = $equitment->getChanges();
        $this->logUpdatedActivity($equitment,$beforeUpdateValues,$afterUpdateValues);

        return redirect('/equitments/'. $emp_id)->with('success', 'Equitment member has been updated Successfully');
    }

    public function getDownload($equitment)
    {
        $equitment = Equitment::findOrFail($equitment);
        $filename = $equitment->filename;
        
        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $equitment = Equitment::findOrFail($id);
        $emp_id = $equitment->employee_id;
        if (!empty($equitment->filename)) {
            $delete_files = public_path("files/{$equitment->filename}");
            unlink($delete_files);
        }
        $equitment->delete();

       	return redirect('/equitments/'. $emp_id)->with('success', 'Equitment member has been deleted Successfully');
    }
}
