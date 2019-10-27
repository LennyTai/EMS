<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'emp_id' => 'unique:employees,emp_id,'. $this->id. ',id',
            'emp_id' => 'nullable|unique:employees,emp_id,'. $this->id. ',id',
            'nric' => 'max:4',
            'dob' => 'required|date',
            'joint_date' => 'required|date',
            'confirmed_date' => 'required_if:job_status,JOINED|date|after_or_equal:joint_date',
            'leave_date' => 'required_if:job_status,RESIGNED,TERMINATED' .(empty($this->leave_date) ?: '|after_or_equal:joint_date'),
            'pr_date' => 'required_with:pr_status',
            'pr_status' => 'required_with:pr_date',
            'pr_date' => 'required_with:pr_status',
            'passport_no' => 'required_with:passport_exp_date',
            'passport_exp_date' => 'required_with:passport_no',
            'bank_name' => 'required_with:bank_acc_no',
            'fin_no' => 'required_with:wp_exp_date,wp_app_date,work_pass',
            // 'work_pass' => 'required_with:fin_no,wp_app_date,wp_exp_date|required_unless:nationality,Singapore',
            'work_pass' => 'required_with:fin_no,wp_app_date,wp_exp_date|required_if:pr_status,null|required_unless:nationality,Singapore',  
            'wp_app_date' => 'required_with:fin_no,wp_app_date,work_pass',
            'wp_exp_date' => 'required_with:fin_no,wp_app_date,work_pass' .(empty($this->wp_app_date) ?: '|after_or_equal:wp_app_date'),
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            // 'emp_id.required' => 'Employee ID is required',
            'emp_id.unique' => 'Employee ID has already been taken',
            'name.required' => 'Employee Name is required',
           
            'dob.required' => 'Date of Birth is required',
            'image.sometimes' => 'Image type must be jpeg,png,jpg,gif,and max file size 2048KB',
            'joint_date.required' => 'Joint Date is required',
            'confirmed_date.required' => 'Confirmation Date is required',
            'fin_no.required_with' => 'Fin Number is required when either Work Pass, Work Expiry Date, Work Pass is present',
            'wp_app_date.required_with' => 'Work Application Date is required when either Fin Number, Work Expiry Date, Work Pass is present',
            'wp_exp_date.required_with' => 'Work Expiry Date is required when either Fin Number, Work Application Date, Work Pass is present',
            'work_pass.required_with' => 'Work Pass is required when either Fin Number, Work Application Date, Work Expiry Date is present',
            'passport_no.required_with' => 'Passport Number is required when passport expiry date is present',
            'passport_exp_date.required_with' => 'Passport Expiry Date is required when passport number is present',
        ];
    }
}
