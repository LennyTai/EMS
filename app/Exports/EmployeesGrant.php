<?php

namespace App\Exports;

use App\Employee;
use App\Grant;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use carbon\carbon;
use App\Exports\AttributeOption;

class EmployeesGrant implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {       
            // // Working but can't join table employees
            // $sal = DB::table('salaries')
            // ->orderby('created_at','desc')
            // ->get(['id','dpt_name', 'int_job_title', 'ext_job_title','employee_id','entity'])
            // ->unique('employee_id');

            //OK- except dob not format
            $sal = DB::table('salaries')
             ->Join('employees', 'employee_id', '=', 'employees.id')
             ->orderby('salaries.created_at','desc')
            ->get(['employee_id','emp_id', 'name','dpt_name', 'int_job_title', 'ext_job_title','salaries.entity', DB::raw('DATE_FORMAT(DOB, "%d/%m/%Y") as DOB') ,DB::raw('TIMESTAMPDIFF(year, dob, now()) as age')])
            ->unique('employee_id');



             // ->Join('employees', 'employee_id', '=', 'employees.id')
             //  ->select('emp_id', 'name', 'dpt_name', 'int_job_title', 'ext_job_title', 'salaries.entity', 'dob' ,DB::raw('TIMESTAMPDIFF(year, dob, now()) as age'))
             //  ->get();

            // $query = AttributeOption::selectRaw('id','dpt_name', 'int_job_title', 'ext_job_title','employee_id','entity')
            //     ->from(\DB::raw($sal->toSql() ))
            //     ->mergeBindings($sal->getQuery())
            //     ->Join('employees', 'employee_id', '=', 'employees.id')
            //     ->groupBy('employee_id')
            //     ->get();


           // only 1 object output
            // $sal = DB::table('employees')
            // ->Join('salaries', 'employees.id', '=', 'salaries.employee_id')
            // ->orderby('salaries.created_at','desc')
            // ->distinct('salaries.employee_id')
            // ->select('emp_id', 'name', 'dpt_name', 'int_job_title', 'ext_job_title', 'salaries.entity', 'dob' ,DB::raw('TIMESTAMPDIFF(year, dob, now()) as age'))           
            // ->get(['employees.id','dpt_name', 'int_job_title', 'ext_job_title','employee_id','entity'])
            // ->distinct('salaries.employee_id')

            //Double emp_id
            // $sal = DB::table('salaries')
            // ->orderby('salaries.created_at','desc')
            // ->distinct('salaries.employee_id')
            // ->Join('employees','salaries.employee_id' , '=', 'employees.id')
            
            // ->select('emp_id', 'name', 'dpt_name', 'int_job_title', 'ext_job_title', 'salaries.entity', 'dob' ,DB::raw('TIMESTAMPDIFF(year, dob, now()) as age'))  
           

            // $sal = DB::table('employees')
            // ->Join('salaries', 'employees.id', '=', 'salaries.employee_id')
            // ->orderby('salaries.created_at','desc')
           
            
            // dd($sal);

            // $query->select('id')->where('datetime', DB::raw("(select max('datetime') from table)"));
            // })->orderBy('id', 'desc')->first();
            
            // $users = DB::table('users')->distinct()->get();

              
           // $Test = DB::table('employees')
           //  ->Join('salaries', 'employees.id', '=', 'salaries.employee_id')
           //  ->orderby('salaries.created_at','desc')
           //  ->select('emp_id', 'name', 'dpt_name', 'int_job_title', 'ext_job_title', 'salaries.entity', 'dob' ,DB::raw('TIMESTAMPDIFF(year, dob, now()) as age'))
           //  ->unique('employees.employee_id')
           //  ->get();
            
           // dd($sal);

        // $grant = DB::table('employees')
        //     ->Join('salaries', 'employees.id', '=', 'salaries.employee_id')
        //     ->Join('grants', 'grants.id', '=', 'employees.grant_id')
        //     ->Join('grant_payments', 'grants.id', '=', 'grant_payments.grant_id')
        //     ->select('emp_id', 'name', 'dob', 'int_job_title', 'ext_job_title', 'dpt_name', 'salaries.entity', 'salary', 'program', 'course', 'start_date', 'end_date', 'payment_due_date', 'payment_date', 'payment_amt', 'payment_no')
        //     ->where('job_status', 'JOINED')->orWhere('job_status', 'PROBATION')
        //     ->latest('salaries.created_at')->get();

        // $tests = DB::table('employees')
        //     ->join('grants', 'grants.id', '=', 'employees.grant_id')
        //     ->join('salaries', 'employees.id', '=', 'salaries.employee_id')
        //     ->get();

           
        // foreach ($tests as $test) {
        //  $fin = $test ->salary;}
        
      

        

        

        return $sal;
    }

    public function headings(): array
    {
        return [
			'Employee ID',
			'Name',
            'Date of Birth',
			'Internal Job Title',
			'External Job Title',
			'Department Name',
			'Entity',
            'Salary',
            'Program',
            'Course Duration',
            'Start Date',
            'End Date',
            'Payment Due Date',
            'Payment Date',
            'Payment Amount',
            'Payment Receivable',
            'Payment Balance',
            'Payment Number'
        ];
    }
}