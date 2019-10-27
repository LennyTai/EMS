<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Employee;
use App\Activity;
use App\Salary;
use App\Traits\ActivityTraits;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use ActivityTraits, SoftDeletes;

	// Mass Assign
    protected $guarded = [];

    // One to Many
    public function employees()
    {
        return $this->hasMany('App\Employee');
    }

    // One to Many
    public function salaries()
    {
        return $this->hasMany('App\Salary');
    }

    // Count for Joined Emp
    public function joined_count()
    {
    	$count = Employee::where('job_status', 'JOINED')->count();
    }

    // Total Employee by Department
    public function dpt_count()
    {
        // $count = Employee::where('job_status', 'JOINED')->count();
        $count = DB::table('departments')
                ->join('employees', 'departments.id', '=', 'employees.department_id')
                ->select(DB::raw('count(*) as total'), 'dpt_name')
                ->where('employees.job_status', '=', 'JOINED')
                ->groupBy('dpt_name')
                ->pluck('total', 'dpt_name')->all();
    }
}
