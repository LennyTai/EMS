<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisciplinaryRequest extends FormRequest
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
            'incident'=>'required',
            'TOD'=> 'required',
            'issued_date'=> 'required|date',
            'remarks'=> 'required',
            // 'uploaded' => 'sometimes|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'incident.required'=> 'Incident is required',
            'TOD.required'=> 'Type of discipline is required',
            'correction.required'=> ' Correction action is required',
            'issued_date.required'=> 'Issued date is required',
            'review_date.required'=> 'Review date is required',
            'remarks.required'=> 'Remarks is required',
            'employee_id.required'=> 'Employee is required',
            'uploaded.mimes' => 'Invalid format, the attachment must be either jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx',
            'uploaded.sometimes' => 'No attachment to upload',
            'uploaded.max' => 'The attachment may not be greater than 1mb'

        ];
    }
}
