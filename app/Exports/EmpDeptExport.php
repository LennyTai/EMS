<?php

namespace App\Exports;

use App\Employee;
use App\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class EmpDeptExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   
    public function collection()
    {	
    	$EmpDeptExport = DB::table('employees')
    		->leftJoin('salaries', 'employees.id' , '=', 'salaries.employee_id' )
    		->select('employees.emp_id', 'name', 'salaries.int_job_title', 'salaries.ext_job_title', 'salaries.entity', 'salaries.department_id')
    		->where('job_status','PROBATION')->orWhere('job_status','JOINED')
    		->get();

       return $EmpDeptExport;
		
    }
    public function headings(): array
    {
        return [
			'Employee Id',
			'name',
			'internal job Title',
			'ext_job_title',
			'entity',
			'Department Id'
        ];
    }
}