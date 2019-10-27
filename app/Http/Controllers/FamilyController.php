<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FamilyRequest;
use App\Family;
use App\Employee;

class FamilyController extends Controller
{
    public function index(Employee $employee)
    {
        $emp_name = $employee->name;
        $emp_id = $employee->id;
        $families = Family::with('employee')->where('employee_id', '=', $emp_id)->get();

        return view('families.index', compact('families', 'emp_name', 'emp_id'));
    }

    public function create(Employee $employee)
    {
        $family = new Family;
        $emp_id = $employee->id;
        $family->employee_id = $emp_id;

        return view('families.create',compact('family', 'employee'));
    }

    public function store(FamilyRequest $request)
    {
        $emp_id = $request->employee_id;
        $emp_name = $request->name;
        $families = Family::with('employee')->where('employee_id', '=', $emp_id)->get();
        $family = new Family;
        $family->fill($request->all());

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                if (!empty($family->filename)) {
                    $delete_files = public_path("files/{$family->filename}");
                    unlink($delete_files);
                }
                $family->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $family->filename);
            }
        }

        $familyParms = $family->toArray();
        $changes = 'Family member created by ' . auth()->user()->name;
        $family->save();
        $family = $family->latest()->first();
        $this->logCreatedActivity($family, $changes ,$familyParms);


        return redirect('/families/'. $emp_id)->with('success', 'Family member has been added Successfully');
    }

    public function edit($id)
    {
        $family = Family::findOrFail($id);
        $emp_id = $family->employee_id;

        return view('families.edit', compact('family', 'emp_id'));
    }

    public function update(FamilyRequest $request, $id)
    {
      	$family = Family::findOrFail($id);
        $emp_id = $request->employee_id;

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                if (!empty($family->filename)) {
                    $delete_files = public_path("files/{$family->filename}");
                    unlink($delete_files);
                }
                $family->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $family->filename);
            }
        }

        $beforeUpdateValues = $family->toArray();
        $family->fill($request->all())->employee();
        $family->save();
        $afterUpdateValues = $family->getChanges();
        $this->logUpdatedActivity($family,$beforeUpdateValues,$afterUpdateValues);

        return redirect('/families/'. $emp_id)->with('success', 'Family member has been updated Successfully');
    }

    public function getDownload($family)
    {
        $family = Family::findOrFail($family);
        $filename = $family->filename;
        
        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $family = Family::findOrFail($id);
        $emp_id = $family->employee_id;
        if (!empty($family->filename)) {
            $delete_files = public_path("files/{$family->filename}");
            unlink($delete_files);
        }
        $family->delete();

       	return redirect('/families/'. $emp_id)->with('success', 'Family member has been deleted Successfully');
    }
}
