<?php

namespace App\Exports;

use App\Employee;
use App\Grant;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use carbon\carbon;

class EmployeesTermination implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
              
        $xEmp = DB::table('employees')
            ->leftJoin('salaries', 'employees.id', '=', 'salaries.employee_id')
            ->select('emp_id', 'name', 'dpt_name', 'salaries.entity', DB::raw('DATE_FORMAT(joint_date, "%d/%m/%Y") as join_date') , DB::raw('DATE_FORMAT(leave_date, "%d/%m/%Y") as Leave_Date'))
            ->Where('job_status', 'RESIGNED')->orWhere('job_status', 'TERMINATED')->get();

        dd($xEmp);
   

        return $xEmp;
    }

    public function headings(): array
    {
        return [
			'Employee ID',
			'Name',
            'Department',
			'Company',
			'Join Date',
			'Terminate/Resigned Date',
        ];
    }
}