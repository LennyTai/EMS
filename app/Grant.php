<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Grant extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public $incrementing = true;

    protected $dates = [
        'date_of_acceptance',
        'date_of_application',
        'date_of_form_submission',
        'date_of_submission',
        'payment_date',
        'start_date',
        'end_date',
        'deleted_at'
    ];

    public function employee()
    {
        return $this->hasOne('App\Employee');
    }

    public function grant_payments()
    {
        return $this->hasMany('App\GrantPayment');
    }

    public function emp_name()
    {
        $employees = Employee::findOrFail($this->employee_id);
        if (isset($employees->name)) {
            return $employees->name;
        }
    }

    public function salaries()
    {
        $employees = Employee::findOrFail($this->employee_id);
        $emp_id = $employees->id;
        $salaries = Salary::with('employee')->where('employee_id', '=', $emp_id)->latest()->first();
        if (isset($salaries->salary)) {
            return $salaries->salary;
        }
    }

    public function grants()
    {
        $employees = Employee::findOrFail($this->employee_id);
        $age = $employees->dob->diff(Carbon::now())->format('%y');
        $emp_id = $employees->id;
        $salaries = Salary::with('employee')->where('employee_id', '=', $emp_id)->latest()->first();
        if (isset($salaries->salary)) {
            $salary = $salaries->salary;
            if ($age < '40' && $salary >= '4000') {
                return '4000' * '0.7';
            } elseif ($age < '40' && $salary < '4000') {
                return $salary * '0.7';
            } elseif ($age >= '40' && $salary >= '6000') {
                return '6000' * '0.9';
            } elseif ($age >= '40' && $salary < '6000') {
                return $salary * '0.9';
            }
        }
    }

    public function grantPayment()
    {
        if ($this->course === '9 Months') {
            return ($this->grants() * 9) / 3;
        } else {
            return ($this->grants() * 12) / 4;
        }
    }
}
