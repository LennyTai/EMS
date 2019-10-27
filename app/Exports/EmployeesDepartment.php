<?php

namespace App\Exports;

use App\Employee;
use App\Salary;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesDepartment implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$salary = DB::table('employees')
    	    ->leftJoin('salaries as empsal', 'employees.id', '=', 'empsal.employee_id')
    	    ->select('emp_id', 'name', 'empsal.int_job_title', 'empsal.ext_job_title', 'empsal.dpt_name', 'empsal.entity')
    	    ->where('job_status', 'JOINED')->orWhere('job_status', 'PROBATION')
    	    ->get();

        return $salary;
    }

    public function headings(): array
    {
        return [
			'Employee ID',
			'Name',
			'Internal Job Title',
			'External Job Title',
			'Department Name',
			'Entity',
        ];
    }
}