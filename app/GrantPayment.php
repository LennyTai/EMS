<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class GrantPayment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public $incrementing = true;

    protected $dates = [
        'payment_date',
        'payment_due_date'
    ];

    public function grant()
    {
        return $this->belongsTo('App\Grant');
    }

    public function emp_name($employee)
    {
    	$emp_name = Employee::findOrFail($employee);
        return $emp_name->name;
    }

    public function grantPayment()
    {
    	$grant = Grant::where('id', $this->grant_id)->first();
        if ($grant->course === '9 Months') {
            return ($grant->grants() * 9) / 3;
        } else {
            return ($grant->grants() * 12) / 4;
        }
    }

    public function grantBalance()
    {
        $TotalPay = 0;
        // $grantId = $this->grant_id;
        // $grantNo = $this->payment_no;
        $grantsBl = DB::Table('grant_payments')->where('grant_id',$this->grant_id)->where('payment_no',$this->payment_no)->get();

        foreach ($grantsBl as $grantBl ) {
            $TotalPay += $grantBl->payment_amt;
        }  

        if (isset($this->payment_amt)) {
            return $this->grantPayment() - $TotalPay;
        } else {
            return $this->grantPayment();
        }
            
    } 

    //  public function grantBalance()
    // {
    //     if (isset($this->payment_amt)) {
    //         return $this->grantPayment() - $this->payment_amt;
    //     } else {
    //         return $this->grantPayment();
    //     }
    // }   

}
