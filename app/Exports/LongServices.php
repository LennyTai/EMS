<?php

namespace App\Exports;

use App\Employee;
use App\Grant;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use carbon\carbon;

class LongServices implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $yr = 5;
              
        $LgSvr = DB::table('employees')
            ->leftJoin('salaries', 'employees.id', '=', 'salaries.employee_id')
            ->select('emp_id', 'name', 'dpt_name', 'salaries.entity',  DB::raw('DATE_FORMAT(joint_date, "%d/%m/%Y") as join_date'), DB::raw('TIMESTAMPDIFF(year, joint_date, now()) as yrdif'))
           ->having('yrdif','>=',$yr)->get();

           dd($LgSvr);

        return $LgSvr;
    }

    public function headings(): array
    {
        return [
			'Employee ID',
			'Name',
            'Department',
			'Company',
			'Join Date',
			'No. of years join',
        ];
    }
}