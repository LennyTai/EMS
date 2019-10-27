<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
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
            'TOE' => 'required',
            'issued_date' => 'required|date',
            'size' => 'required',
            'employee_id' => 'required',
            // 'uploaded' => 'sometimes|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'TOE.required' => 'Type of Equipment is required',
            'issued_date.required' => 'Issued Date is required',
            'size.required' => 'Size is required',
            'employee_id.required' => 'Employee ID is required',
            'uploaded.mimes' => 'Invalid format, the attachment must be either jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx',
            'uploaded.sometimes' => 'No attachment to upload',
            'uploaded.max' => 'The attachment may not be greater than 1mb'
        ];
    }
}
