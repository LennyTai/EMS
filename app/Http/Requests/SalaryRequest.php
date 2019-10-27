<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryRequest extends FormRequest
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
            // 'salary' => 'required',
            // 'salary_adjust' => 'required',
            'date' => 'required|date',
            'remarks' => 'required',
            'int_job_title' => 'required',
            'dpt_name' => 'required',
            'entity' => 'required',
            'ext_job_title' => 'required',
            // 'uploaded' => 'sometimes|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'salary.required' => 'Salary is required',
            'salary_adjust.required' => 'Type of Salary adjustment is required',
            'date.required' => 'Date is required',
            'remarks.required' => 'Remarks is required',
            'ext_job_title.required' => 'External Job Title is required',
            'int_job_title.required' => 'Internal Job Title is required',
            'dpt_name.required' => 'Department is required',
            'uploaded.mimes' => 'Invalid format, the attachment must be either jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx',
            'uploaded.sometimes' => 'No attachment to upload',
            'uploaded.max' => 'The attachment may not be greater than 1mb'
        ];
    }
}
