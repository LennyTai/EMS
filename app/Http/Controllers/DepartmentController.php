<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
use App\Department;
use App\Employee;
use Spatie\Activitylog\Models\Activity;
use App\Traits\ActivityTraits;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $department = new Department;
        $employee = Employee::pluck('name', 'id');
        // dd($employee);

        return view('departments.create', compact('department', 'employee'));
    }

    public function store(DepartmentRequest $request)
    {
        $department = new Department;
        $department->fill($request->all());
        $dpt_name = $request->dpt_name;

        // Logs
        $departmentParms = $department->toArray();
        $changes = $dpt_name. ' created by ' . auth()->user()->name;
        $department->save();
        $department = $department->latest()->first();
        $this->logCreatedActivity($department, $changes ,$departmentParms);

  	    return redirect('/departments')->with('success', 'Department has been added');
    }

    public function show(Department $department)
    {
        $employee = Employee::pluck('name', 'name');

        return view('departments.show', compact('department', 'employee'));
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $employee = Employee::pluck('name', 'name');

        return view('departments.edit', compact('department', 'employee'));
    }

    public function update(DepartmentRequest $request, $id)
    {
      	$department = Department::findOrFail($id);

        // Logs
        $beforeUpdateValues = $department->toArray();
        $department->fill($request->all());
        $department->save();
        $afterUpdateValues = $department->getChanges();
        $this->logUpdatedActivity($department, $beforeUpdateValues, $afterUpdateValues);

      	return back()->with('success', 'Department has been updated');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        // logs
        $dpt_name = $department->dpt_name;
        $department->delete();
        $changeLog = $dpt_name . ' department has been deleted'; 

        $this->logDeletedActivity($department, $changeLog);

       	return redirect('/departments')->with('success', 'Department has been deleted Successfully');
    }
}
