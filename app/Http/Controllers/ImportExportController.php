<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\EmployeesExport;
use App\Exports\EmployeesDepartment;
use App\Exports\EmployeesGrant;
use App\Exports\EmployeesConfirm;
use App\Exports\EmployeesTermination;
use App\Exports\LongServices;
use App\Exports\LocalForeigners;
use App\Exports\PassportExpires;
use App\Exports\EmployeesAge;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Employee;
use App\Salary;
use DB;

class ImportExportController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function reports()
    {
        return view('reports.index');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function employees()
    {
        return Excel::download(new EmployeesExport, 'employees_list.xlsx');
    }

    public function employeeDepartment()
    {
        return Excel::download(new EmployeesDepartment, 'employees_deparment_list.xlsx');
    }
    public function employeeGrant()
    {
        return Excel::download(new EmployeesGrant, 'employees_Grant_list.xlsx');
    }

    public function employeeConfirm()
    {
        return Excel::download(new EmployeesConfirm, 'Confirmation Report.xlsx');
    }    

    public function employeeTermination()
    {
        return Excel::download(new EmployeesTermination, 'Termination Report.xlsx');
    }

    public function LongService()
    {
        return Excel::download(new LongServices, 'Long Service Report.xlsx');
    }

    public function LocalForeigner()
    {
        return Excel::download(new LocalForeigners, 'Local Foreign Report.xlsx');
    }

    public function PassportExpire()
    {
        return Excel::download(new PassportExpires, 'Passport Expire Report.xlsx');
    }

    public function EmployeeAge()
    {
        return Excel::download(new EmployeesAge, 'Age Report.xlsx');
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function import()
    {
        Excel::import(new EmployeesImport, request()->file('file'));
           
        return back();
    }
}