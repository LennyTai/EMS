<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AllowanceRequest;
use App\Employee;
use App\Allowance;

class AllowanceController extends Controller
{
    public function index(Employee $employee)
    {
        $emp_name = $employee->name;
        $emp_id = $employee->id;
        $allowances = Allowance::with('employee')->where('employee_id', '=', $emp_id)->get();

        return view('allowances.index', compact('allowances', 'emp_name', 'emp_id'));
    }

    public function create(Employee $employee)
    {
        $allowance = new Allowance;
        $emp_id = $employee->id;
        $allowance->employee_id = $emp_id;

        return view('allowances.create',compact('allowance', 'employee'));
    }

    public function store(AllowanceRequest $request)
    {
        $emp_id = $request->employee_id;
        $allowances = Allowance::with('employee')->where('employee_id', '=', $emp_id)->get();
        $allowance = Allowance::create($request->all());

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($allowance->filename)) {
                    $delete_files = public_path("files/{$allowance->filename}");
                    unlink($delete_files);
                }
                $allowance->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $allowance->filename);
            }
        }

        $allowanceParms = $allowance->toArray();
        $changes = 'Allowance created by ' . auth()->user()->name;
        $allowance->save();
        $allowance = $allowance->latest()->first();
        $this->logCreatedActivity($allowance, $changes ,$allowanceParms);

        return redirect('/allowances/'. $emp_id)->with('success', 'Allowance member has been added Successfully');
    }

    public function edit($id)
    {
        $allowance = Allowance::findOrFail($id);
        $emp_id = $allowance->employee_id;

        return view('allowances.edit', compact('allowance', 'emp_id'));
    }

    public function update(AllowanceRequest $request, $id)
    {
      	$allowance = Allowance::findOrFail($id);
        $emp_id = $request->employee_id;

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($allowance->filename)) {
                    $delete_files = public_path("files/{$allowance->filename}");
                    unlink($delete_files);
                }
                $allowance->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $allowance->filename);
            }
        }

        $beforeUpdateValues = $allowance->toArray();
        $allowance->fill($request->all())->employee();
        $allowance->save();
        $afterUpdateValues = $allowance->getChanges();
        $this->logUpdatedActivity($allowance,$beforeUpdateValues,$afterUpdateValues);

        return redirect('/allowances/'. $emp_id)->with('success', 'Allowance member has been updated Successfully');
    }

    public function getDownload($allowance)
    {
        $allowance = Allowance::findOrFail($allowance);
        $filename = $allowance->filename;
        
        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $allowance = Allowance::findOrFail($id);
        $emp_id = $allowance->employee_id;
        if (!empty($allowance->filename)) {
            $delete_files = public_path("files/{$allowance->filename}");
            unlink($delete_files);
        }
        $allowance->delete();

       	return redirect('/allowances/'. $emp_id)->with('success', 'Family member has been deleted Successfully');
    }
}
