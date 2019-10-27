<?php

namespace App\Exports;

use App\Employee;
use App\Grant;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use carbon\carbon;

class PassportExpires implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
              
        $LF = DB::table('employees')
            ->leftJoin('salaries', 'employees.id', '=', 'salaries.employee_id')
            ->select('emp_id', 'name', 'dpt_name', 'salaries.entity', 'passport_no' , DB::raw('DATE_FORMAT(passport_exp_date, "%d/%m/%Y") as Passport_Expired_Date'))
            ->Where('nationality','not like','Singapore')->get();
        dd($LF);

        return $LF;
    }

    public function headings(): array
    {
        return [
			'Employee ID',
			'Name',
			'Department',
			'Company',
            'Passport No.',
            'Passport Expiry Date'
        ];
    }
}