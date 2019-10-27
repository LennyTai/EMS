<?php

namespace App\Exports;

use App\Employee;
use App\Grant;
use App\Salary;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use carbon\carbon;

class EmployeesAge implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {   
        // $results = Salary::whereIn('id', function($query){            
        //     $query->select('id')->where('date', DB::raw("(select max('date') from Salaries)"));
        //     })->orderBy('id', 'desc')->first();

        //     $id = 3; 

        //     $results = salary::orderBy('date', 'desc')->limit($id)->get();


        $Age = DB::table('employees')
            ->Join('salaries', 'employees.id', '=', 'salaries.employee_id')
            ->select('emp_id', 'name', 'dpt_name', 'int_job_title', 'ext_job_title', 'salaries.entity', DB::raw('DATE_FORMAT(dob, "%d/%m/%Y") as DOB') ,DB::raw('TIMESTAMPDIFF(year, dob, now()) as age'))
                ->get();

        // $Test = DB::table('employees')
        //     ->Join('salaries', 'employees.id', '=', 'salaries.employee_id')
        //     ->select('emp_id', 'name', 'dpt_name', 'int_job_title', 'ext_job_title', 'salaries.entity', 'dob' ,DB::raw('TIMESTAMPDIFF(year, dob, now()) as age'))
        //     ->Where('int_job_title')->latest()
        //         ->get();


        dd($Age);

        return $Age;
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Name',
            'Department',
            'Company',
            'Date of Birth',
            'Age',

        ];
    }
}