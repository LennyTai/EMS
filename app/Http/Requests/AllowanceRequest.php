<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllowanceRequest extends FormRequest
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
            'TOA' =>'required',
            'allowance_amt' => 'required',
            'issued_date' => 'required|date',
            'employee_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'TOA.required' =>'Type of Allowance is required',
            'allowance_amt.required' => 'Allowance amount is required',
            'issued_date.required' => 'Issued date is required',
            'employee_id.required' => 'Employee ID is required',
            'uploaded.mimes' => 'Invalid format, the attachment must be either jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx',
            'uploaded.sometimes' => 'No attachment to upload',
            'uploaded.max' => 'The attachment may not be greater than 1mb'
        ];
    }
}
