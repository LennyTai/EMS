<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
	// Mass Assign
    protected $guarded = [];

    public $incrementing = true;

    protected $dates = [
        'dob',
        'passport_exp_date',
        'wp_app_date',
        'wp_exp_date',
        'leave_date',
        'joint_date',
        'confirmed_date',
        'pr_date',
        'deleted_at'
    ];

    protected $defaults = [
        'job_status' => 'PROBATION',
    ];

    // Download Files
    public function downloadFile($id)
    {
        $id = Employee::findOrFail($id);
        $emp_id = $id->id;
        $download_file = DB::table('employees')
            ->leftJoin('upload_files as upload', 'employees.id', '=', 'upload.employee_id')
            ->select('upload.filename', 'employee_id')
            ->where('upload.employee_id', $emp_id)
            ->get('filename');
        $download_file->toArray();

        return $download_file;
    }

    // Total Countries
    public function country()
    {
        return $this->where('job_status', 'JOINED')->distinct('nationality')->count('nationality');
    }

    // Total Salaries
    public function salary()
    {
        return number_format($this->where('job_status', 'JOINED')->sum('salary'),0);
    }

   
    // Total Joined Emp
    public function tot_emp()
    {
        return $this->where('job_status', 'JOINED')->orWhere('job_status', 'PROBATION')->count();
    }

    // Total Department
    public function tot_dpt()
    {
        $tot_dpt = DB::table('employees')
            ->leftJoin('salaries', 'employees.id', '=', 'salaries.employee_id')
            ->select('salaries.dpt_name')
            ->where('job_status', 'JOINED')->orWhere('job_status', 'PROBATION')
            ->distinct('dpt_name')->count('dpt_name');
        return $tot_dpt;
    }

    // Total Entity
    // public function tot_entity()
    // {
    //     $tot_entity = DB::table('employees')
    //         ->leftJoin('salaries', 'employees.id', '=', 'employee_id')
    //         ->select('entity')
    //         ->where('job_status', 'JOINED')->orWhere('job_status', 'PROBATION')
    //         ->distinct('entity')->count('entity');
    //     return $tot_entity;
    // }
     public function tot_NewHired()
    {
        $tot_NewHired = DB::table('employees')
            ->where('job_status', 'PROBATION')
            ->count('employees.id');
        return $tot_NewHired;
    }

    // public function tot_Resigned()
    // {
    //     $tot_Resigned = DB::table('employees')
    //         ->where('job_status', 'RESIGNED')
    //         ->count('employees.id');
    //     return $tot_Resigned;
    // }

public function tot_Resigned()
    {
        $now = carbon::now();

        $tot_Resigned = DB::table('employees')
            ->where('job_status', 'RESIGNED')
            ->whereMonth('leave_date','=',$now)
            ->whereYear('leave_date','=',$now)
             ->orWhere('job_status', 'TERMINATED')
            ->whereMonth('leave_date','=',$now)
            ->whereYear('leave_date','=',$now)
           
            ->count('employees.id');
        return $tot_Resigned;
    }

    // Int Job Title
    public function job_title()
    {
        $salaries = Salary::with('employee')->where('employee_id', '=', $this->id)->latest()->first();
        if (isset($salaries)) {
            return $salaries->int_job_title;
        }
    }

    // Total Fundings
    public function fund()
    {
        return number_format($this->where('job_status', 'JOINED')->sum('salary')*0.5,0);
    }

    // CheckStatus
    private function checkStatus(Request $request, string $value)
    {
        if ($request->has('job_status')) {
            return in_array($value, $request->input('job_status'));
        }   
        return false;
    }

    // Date format
	// public function setDobAttribute($value)
	// {
 //        dd(strlen($value));
 //    	$this->attributes['dob'] = strlen($value)? Carbon::createFromFormat('Y-m-d', $value) : null;
 //    }

    // Birthday
    public function getConfirmation()
    {
        if ($this->job_status === 'JOINED' || $this->job_status === 'PROBATION') {
            if (isset($this->confirmed_date)) {
                $now = Carbon::now();
                if ($this->confirmed_date < $now) {
                return $this->confirmed_date->diff(Carbon::now())->format('-%mm %dd');
                }
                return $this->confirmed_date->diff(Carbon::now())->format('%mm %dd');
            }
        }
    }

    // Years of Status
    public function getYearsOfStatus()
    {
        if ($this->job_status === 'JOINED' || $this->job_status === 'PROBATION') {
            return $this->joint_date->diff(Carbon::now())->format('%y years, %m months, %d days');
        } else {
            return $this->leave_date->diff(Carbon::now())->format('%y years, %m months, %d days');
        }
    }

    // Years of Services
    public function getYearsOfServices()
    {
        if ($this->job_status === 'TERMINATED' || $this->job_status === 'RESIGNED') {
            if (isset($this->leave_date)) {
                return $this->joint_date->diff($this->leave_date)->format('%y years, %m months, %d days');
            }
        } else {
            return $this->joint_date->diff(Carbon::now())->format('%y years, %m months, %d days');
        }
    }

    // Age
	public function getAge()
	{
	    return $this->dob->diff(Carbon::now())->format('%y');
	}

    public function getConfirm()
    {
        return $this->confirmed_date->diff(Carbon::now())->format('%y');
    }
    // One to Many Inverse
    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    // One to Many Inverse
    public function grant()
    {
        return $this->belongsTo('App\Grant');
    }

    // One to Many
    public function families()
    {
        return $this->hasMany('App\Family');
    }

    // One to Many
    public function disciplinaries()
    {
        return $this->hasMany('App\Disciplinary');
    }

    // One to Many
    public function allowances()
    {
        return $this->hasMany('App\Allowance');
    }
    
    // One to Many
    public function equipments()
    {
        return $this->hasMany('App\Equipment');
    }

    // One to Many
    public function salaries()
    {
        return $this->hasMany('App\Salary');
    }

    // One to Many
    public function qualifications()
    {
        return $this->hasMany('App\Qualification');
    }

    // One to Many
    public function upload_files()
    {
        return $this->hasMany('App\UploadFile');
    }

    // One to Many
    public function attachments()
    {
        return $this->hasMany('App\Attachment');
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($employee) {
    //         $employee->slug = time() . str_slug($employee->name);
    //     });
    // }
}