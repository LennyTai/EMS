<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SalaryRequest;
use App\Salary;
use App\Employee;
use App\Department;
use DB;

class SalaryController extends Controller
{
    public function index(Employee $employee)
    {
        $emp_name = $employee->name;
        $emp_id = $employee->id;
        $salaries = Salary::with('employee')->where('employee_id', '=', $emp_id)->get();

        return view('salaries.index', compact('salaries', 'emp_name', 'emp_id'));
    }

    public function create(Employee $employee)
    {
        $salary = new Salary;
        $emp_id = $employee->id;
        $salary->employee_id = $emp_id;
        $employees = Employee::pluck('name', 'name');

        return view('salaries.create',compact('salary', 'employee', 'employees'));
    }

    public function store(SalaryRequest $request)
    {
        $emp_id = $request->employee_id;
        $emp_name = $request->name;
        $salaries = Salary::with('employee')->where('employee_id', '=', $emp_id)->get();
        $salary = Salary::create($request->all());

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($salary->filename)) {
                    $delete_files = public_path("files/{$salary->filename}");
                    unlink($delete_files);
                }
                $salary->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $salary->filename);
            }
        }

        $salaryParms = $salary->toArray();
        $changes = 'Salary created by ' . auth()->user()->name;
        $salary->save();
        $salary = $salary->latest()->first();
        $this->logCreatedActivity($salary, $changes ,$salaryParms);

        return redirect('/admin/salaries/'. $emp_id)->with('success', 'Salary information has been added Successfully');
    }

    public function edit($id)
    {
        $salary = Salary::findOrFail($id);
        $emp_id = $salary->employee_id;
        $employees = Employee::pluck('name', 'name');

        return view('salaries.edit', compact('salary', 'employees', 'emp_id'));
    }

    public function update(SalaryRequest $request, $id)
    {
      	$salary = Salary::findOrFail($id);
        $emp_id = $request->employee_id;

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($salary->filename)) {
                    $delete_files = public_path("files/{$salary->filename}");
                    unlink($delete_files);
                }
                $salary->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $salary->filesize = $request->file('uploaded')->getClientSize();
                $salary->content_type = $request->file('uploaded')->extension();
                $request->file('uploaded')->move(public_path('files/'), $salary->filename);
            }
        }

        $beforeUpdateValues = $salary->toArray();
        $salary->fill($request->all())->employee();
        $salary->save();
        $afterUpdateValues = $salary->getChanges();
        $this->logUpdatedActivity($salary,$beforeUpdateValues,$afterUpdateValues);

        return redirect('/admin/salaries/'. $emp_id)->with('success', 'Salary member has been updated Successfully');
    }

    public function getDownload($salary)
    {
        $salary = Salary::findOrFail($salary);
        $filename = $salary->filename;
        
        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $salary = Salary::findOrFail($id);
        $emp_id = $salary->employee_id;
        if (!empty($salary->filename)) {
            $delete_files = public_path("files/{$salary->filename}");
            unlink($delete_files);
        }
        $salary->delete();

       	return redirect('/admin/salaries/'. $emp_id)->with('success', 'Salary member has been deleted Successfully');
    }
}
