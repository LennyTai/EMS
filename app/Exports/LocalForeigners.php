<?php

namespace App\Exports;

use App\Employee;
use App\Grant;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use carbon\carbon;

class LocalForeigners implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
              
        $LF = DB::table('employees')
            ->leftJoin('salaries', 'employees.id', '=', 'salaries.employee_id')
            ->select('emp_id', 'name', 'dpt_name', 'salaries.entity', DB::raw(('(case When
                nationality like "Singapore" THEN "LOCAL" ELSE "FOREIGN" END) as status')))
            ->get();

        return $LF;
    }

    public function headings(): array
    {
        return [
			'Employee ID',
			'Name',
			'Department',
			'Company',
            'Employment Status',
 
        ];
    }
}