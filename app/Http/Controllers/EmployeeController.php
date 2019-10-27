<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Employee;
use App\Salary;
use DB;
use Image;
use Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $employee = new Employee;

        return view('employees.create', compact('employee'));
    }

    public function store(EmployeeRequest $request)
    {
        $employee = new Employee;
        $request->validate([
            'emp_id' => 'unique:employees,emp_id,' . $employee->emp_id. ',emp_id',
        ]);

        $employee = Employee::create($request->all());
        $emp_name = $request->name;

        if ($request->hasfile('image')) {
            $emp_image = $request->file('image');
            $filename = $employee->emp_id .'_'. time() .'.'. $emp_image->getClientOriginalExtension();
            $location = public_path('images/') . $filename;
            Image::make($emp_image)->resize(180, 220)->save($location);
            $employee->filename = $filename;
        }

        $employeeParms = $employee->toArray();
        $changes = $emp_name.' created by ' . auth()->user()->name;
        $employee->save();
        $employee = $employee->latest()->first();
        $this->logCreatedActivity($employee, $changes ,$employeeParms);

  	    return redirect('/employees')->with('success', 'Employee has been added successfully');
    }

    public function edit($employee)
    {
        $employee = Employee::findOrFail($employee);
        $id = $employee->id;
        $salaries = Salary::with('employee')->where('employee_id', '=', $id)->latest()->first();

        return view('employees.edit', compact('employee', 'salaries'));
    }

    public function update(EmployeeRequest $request, $id)
    {
      	$employee = Employee::findOrFail($id);
        $request->validate([
            'id' => 'unique:employees,id,' . $employee->id. ',id',
            'emp_id' => 'unique:employees,emp_id,' . $employee->emp_id. ',emp_id',
        ]);

        if ($request->hasfile('image')) {
            $delete_image = public_path("/images/{$employee->filename}");
            if (!empty($employee->filename)) {
                unlink($delete_image);
            }
            $emp_image = $request->file('image');
            $filename = $employee->emp_id .'_'. time() .'.'. $emp_image->getClientOriginalExtension();
            $location = public_path('images/') . $filename;
            Image::make($emp_image)->resize(180, 220)->save($location);
            $employee->filename = $filename;
        }

        $beforeUpdateValues = $employee->toArray();
        $employee->fill($request->all());
        $employee->save();
        $afterUpdateValues = $employee->getChanges();
        $this->logUpdatedActivity($employee,$beforeUpdateValues,$afterUpdateValues);

      	return redirect()->back()->with('success', 'Employee has been updated');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $delete_image = public_path("/images/{$employee->filename}");
        if (!empty($employee->image)) {
            unlink($delete_image);
        }

        $employee->delete();
       	
        return redirect('/employees')->with('success', 'Employee has been deleted successfully');
    }
}