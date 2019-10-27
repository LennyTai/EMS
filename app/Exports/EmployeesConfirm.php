<?php

namespace App\Exports;

use App\Employee;
use App\Grant;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesConfirm implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
           $confirm = DB::table('employees')
            ->Join('salaries', 'employees.id', '=', 'salaries.employee_id')
            ->select('emp_id', 'name', 'dpt_name', 'salaries.entity', DB::raw('DATE_FORMAT(joint_date, "%d/%m/%Y") as join_date'), DB::raw('DATEDIFF(confirmed_date, now()) as daydif'))
            ->Where('job_status', 'PROBATION')->get();

           

        dd($confirm);
   
   
        return $confirm;
    }

    public function headings(): array
    {
        return [
			'Employee ID',
			'Name',
            'Department',
			'Company',
			'Joined Date',
			'Due to Confirm'
        ];
    }
}