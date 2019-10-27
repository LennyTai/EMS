<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GrantPaymentRequest;
use App\GrantPayment;
use App\Grant;
use App\Employee;
use DB;

class GrantPaymentController extends Controller
{
    public function index(Grant $grant)
    {
        $grant_name = Employee::with('grant')->where('grant_id', '=', $grant->id)->latest()->first();
        $grant_payments = GrantPayment::with('grant')->where('grant_id', '=', $grant->id)->get();

        $grant_paid = $grant_payments->sum('payment_amt');
    	$grants = Grant::where('id', $grant->id)->first();
		$grant_balance = $grant->grants() * 12 - $grant_paid;

        return view('grant_payments.index', compact('grant_payments', 'grant', 'grant_name', 'grant_balance'));
    }

    public function create(Grant $grant)
    {
        $grant_payment = new GrantPayment;
        $grant_payment->grant_id = $grant->id;

        return view('grant_payments.create', compact('grant_payment', 'grant'));
    }

    public function store(GrantPaymentRequest $request)
    {
        $grant_id = $request->grant_id;
        $grant_payment = GrantPayment::create($request->all());

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                if (!empty($grant_payment->filename)) {
                    $delete_files = public_path("files/{$grant_payment->filename}");
                    unlink($delete_files);
                }
                $grant_payment->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $grant_payment->filename);
            }
        }

        $grant_paymentParms = $grant_payment->toArray();
        $changes = 'Grant Payment created by ' . auth()->user()->name;
        $grant_payment->save();
        $grant_payment = $grant_payment->latest()->first();
        $this->logCreatedActivity($grant_payment, $changes ,$grant_paymentParms);

        return redirect('/grant_payments/'. $grant_id)->with('success', 'Grant Payment has been added Successfully');
    }

    public function edit($id)
    {
        $grant_payment = GrantPayment::findOrFail($id);
        $grant_id = $grant_payment->grant_id;

        return view('grant_payments.edit', compact('grant_payment', 'grant_id'));
    }

    public function update(GrantPaymentRequest $request, $id)
    {
      	$grant_payment = GrantPayment::findOrFail($id);
        $grant_id = $request->grant_id;

        if ($request->hasFile('uploaded')) {
            if ($request->file('uploaded')->isValid()) {
                if (!empty($grant_payment->filename)) {
                    $delete_files = public_path("files/{$grant_payment->filename}");
                    unlink($delete_files);
                }
                $grant_payment->filename = time()."_" .$request->file('uploaded')->getClientOriginalName();
                $request->file('uploaded')->move(public_path('files/'), $grant_payment->filename);
            }
        }

        $beforeUpdateValues = $grant_payment->toArray();
        $grant_payment->fill($request->all())->grant();
        $grant_payment->save();
        $afterUpdateValues = $grant_payment->getChanges();
        $this->logUpdatedActivity($grant_payment,$beforeUpdateValues,$afterUpdateValues);

        return redirect('/grant_payments/'. $grant_id)->with('success', 'Grant Payment has been updated Successfully');
    }

    public function getDownload($grant_payment)
    {
        $grant_payment = GrantPayment::findOrFail($grant_payment);
        $filename = $grant_payment->filename;
        
        return response()->download(public_path('files/'. $filename));
    }

    public function destroy($id)
    {
        $grant_payment = GrantPayment::findOrFail($id);
        $grant_id = $grant_payment->grant_id;
        $program = Grant::findOrFail($grant_id);
        if (!empty($grant_payment->filename)) {
            $delete_files = public_path("files/{$grant_payment->filename}");
            unlink($delete_files);
        }
        $grant_payment->delete();
        $changeLog = $program->program . ' grant has been deleted'; 

        $this->logDeletedActivity($grant_payment, $changeLog);

       	return redirect('/grant_payments/'. $grant_id)->with('success', 'Grant Payment has been deleted Successfully');
    }
}