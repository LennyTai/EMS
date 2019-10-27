<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GrantRequest;
use App\Grant;
use App\GrantPayment;
use App\Employee;
use Carbon\Carbon;
use App\Traits\ActivityTraits;
use Spatie\Activitylog\Models\Activity;

class GrantController extends Controller
{
    public function index()
    {
        $grants = Grant::all();

        return view('grants.index', compact('grants'));
    }

    public function overdueIndex()
    {
        $from = Carbon::now();
        $grant_payments = GrantPayment::with('grant')
            ->where('payment_status', '!=', 'Fully Paid')
            ->orWhereNull('payment_status')
            ->where('payment_due_date', '<=', $from)
            ->get();

        $cumulative = 0;
        foreach ($grant_bals = $grant_payments as $grant_bal) {
            $cumulative += $grant_bal->grantBalance();
        }

        return view('grants.overdueIndex', compact('grant_payments', 'cumulative'));
    }

    public function create()
    {
        $grant = new Grant;
        $to = Carbon::now()->subDays(90);
        $from = Carbon::now();
        // $employee = Employee::where('joint_date', '>', $to)->whereNull('grant_id')->pluck('name', 'id');
        $employee = Employee::whereBetween('joint_date', [$to, $from])->whereNull('grant_id')->pluck('name', 'id');

        return view('grants.create', compact('grant', 'employee'));
    }

    public function store(GrantRequest $request)
    {
        $grant = new Grant;
        $grant->fill($request->all());
        $employee = Employee::findOrFail($grant->employee_id);
        $program = $request->program;

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                if (!empty($grant->filename)) {
                    $delete_files = public_path("files/{$grant->filename}");
                    unlink($delete_files);
                }
                $grant->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $grant->filename);
            }
        }

        $grantParms = $grant->toArray();
        $changes = $program. ' created by ' . auth()->user()->name;
        $grant->save();
        $employee->grant_id = $grant->id;
        $employee->save();
        $grant = $grant->latest()->first();
        $this->logCreatedActivity($grant, $changes ,$grantParms);

  	    return redirect('/grants')->with('success', 'Grant has been added');
    }

    public function edit($id)
    {
        $grant = Grant::findOrFail($id);
        $to = Carbon::now()->subDays(90);
        $employee = Employee::with('grant')
            ->where('grant_id', $id)
            ->orWhereNull('grant_id')
            ->where('joint_date', '>', $to)
            ->pluck('name', 'id');
        $grants = GrantPayment::with('grant')->where('payment_due_date', '<', Carbon::now())->get();

        $grant_payments = GrantPayment::where('grant_id', $id)->get();
        $cumulative = 0;
        foreach ($grant_bals = $grant_payments as $grant_bal) {
            $cumulative += $grant_bal->payment_amt;
        }
        $balance = ($grant->grants() * 12) - $cumulative;

        return view('grants.edit', compact('grant', 'grants', 'employee', 'balance'));
    }

    public function update(GrantRequest $request, $id)
    {
      	$grant = Grant::findOrFail($id);
        $request->validate([
            'employee_id' => 'unique:grants,employee_id,' . $grant->id. 'id',
        ]);

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                if (!empty($grant->filename)) {
                    $delete_files = public_path("files/{$grant->filename}");
                    unlink($delete_files);
                }
                $grant->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $grant->filename);
            }
        }

        $beforeUpdateValues = $grant->toArray();
        $grant->fill($request->all());
        $grant->save();
        $afterUpdateValues = $grant->getChanges();
        $this->logUpdatedActivity($grant, $beforeUpdateValues, $afterUpdateValues);

      	return back()->with('success', 'Grant has been updated');
    }

    public function getDownload($grant)
    {
        $grant = Grant::findOrFail($grant);
        $filename = $grant->filename;

        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $grant = Grant::findOrFail($id);
        $delete_image = public_path("/images/{$grant->filename}");
        if (!empty($grant->image)) {
            unlink($delete_image);
        }

        $program = $grant->program;
        $grant->delete();
        $changeLog = $program . ' grant has been deleted'; 
        $this->logDeletedActivity($grant, $changeLog);

       	return redirect('/grants')->with('success', 'Grant has been deleted Successfully');
    }
}
