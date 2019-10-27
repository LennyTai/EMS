<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EquipmentRequest;
use App\Employee;
use App\Equipment;

class EquipmentController extends Controller
{
    public function index(Employee $employee)
    {
        $emp_name = $employee->name;
        $emp_id = $employee->id;
        $equipments = Equipment::with('employee')->where('employee_id', '=', $emp_id)->get();

        return view('equipments.index', compact('equipments', 'emp_name', 'emp_id'));
    }

    public function create(Employee $employee)
    {
        $equipment = new Equipment;
        $emp_id = $employee->id;
        $equipment->employee_id = $emp_id;

        return view('equipments.create',compact('equipment', 'employee'));
    }

    public function store(EquipmentRequest $request)
    {
        $emp_id = $request->employee_id;
        $emp_name = $request->name;
        $equipments = Equipment::with('employee')->where('employee_id', '=', $emp_id)->get();
        $equipment = Equipment::create($request->all());

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($equipment->filename)) {
                    $delete_files = public_path("files/{$equipment->filename}");
                    unlink($delete_files);
                }
                $equipment->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $equipment->filename);
            }
        }

        $equipmentParms = $equipment->toArray();
        $changes = 'Equipment created by ' . auth()->user()->name;
        $equipment->save();
        $equipment = $equipment->latest()->first();
        $this->logCreatedActivity($equipment, $changes ,$equipmentParms);

        return redirect('/equipments/'. $emp_id)->with('success', 'Equipment member has been added Successfully');
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        $emp_id = $equipment->employee_id;

        return view('equipments.edit', compact('equipment', 'emp_id'));
    }

    public function update(EquipmentRequest $request, $id)
    {
      	$equipment = Equipment::findOrFail($id);
        $emp_id = $request->employee_id;

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                $request->validate(['uploaded' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
                ]);
                if (!empty($equipment->filename)) {
                    $delete_files = public_path("files/{$equipment->filename}");
                    unlink($delete_files);
                }
                $equipment->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $equipment->filename);
            }
        }

        $beforeUpdateValues = $equipment->toArray();
        $equipment->fill($request->all())->employee();
        $equipment->save();
        $afterUpdateValues = $equipment->getChanges();
        $this->logUpdatedActivity($equipment,$beforeUpdateValues,$afterUpdateValues);

        return redirect('/equipments/'. $emp_id)->with('success', 'Equipment member has been updated Successfully');
    }

    public function getDownload($equipment)
    {
        $equipment = Equipment::findOrFail($equipment);
        $filename = $equipment->filename;
        
        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $emp_id = $equipment->employee_id;
        if (!empty($equipment->filename)) {
            $delete_files = public_path("files/{$equipment->filename}");
            unlink($delete_files);
        }
        $equipment->delete();

       	return redirect('/equipments/'. $emp_id)->with('success', 'Equipment member has been deleted Successfully');
    }
}
