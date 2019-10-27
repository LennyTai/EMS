<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::get([
			'emp_id',
			'name',
			'dob',
			'gender',
			'address',
			'marital_status',
			'race',
			'nationality',
			'passport_no',
			'passport_exp_date',
			'pr_status',
			'emp_status',
			'work_pass',
			'fin_no',
			'wp_app_date',
			'wp_exp_date',
			'joint_date',
			'confirmed_date',
			'email',
			'contact',
			'nric',
		]);
    }

    public function headings(): array
    {
        return [
			'Employee ID',
			'Name',
			'Date of Birth',
			'Gender',
			'Address',
			'Marital Status',
			'Race',
			'Nationality',
			'Passport No.',
			'Passport Expiry Date',
			'PR Status',
			'Employment Status',
			'Work Pass',
			'Fin No.',
			'WP App Date',
			'WP Exp Date',
			'Joined Date',
			'Confirmed Date',
			'Email',
			'Contact',
			'NRIC'
        ];
    }
}