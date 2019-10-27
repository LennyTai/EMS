<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
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
            'family_name' => 'required',
            'relationship' => 'required',
            'family_dob' => 'required|date',
            'family_contact' => 'required',
            'employee_id' => 'required',
            'uploaded' => 'sometimes|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'family_name.required' => 'Family member name is required',
            'relationship.required' => 'Family member relationship is required',
            'family_dob.required' => 'Family member date of birth is required',
            'family_contact.required' => 'Family member contact number is required',
            'uploaded.mimes' => 'Invalid format, the attachment must be either jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx',
            'uploaded.sometimes' => 'No attachment to upload',
            'uploaded.max' => 'The attachment may not be greater than 1mb'
        ];
    }
}
