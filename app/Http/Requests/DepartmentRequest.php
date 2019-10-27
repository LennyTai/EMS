<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'dpt_name'=>'required',
            // 'hod'=> 'required',
            // 'company'=> 'required',
        ];
    }

    public function messages()
    {
        return [
            'dpt_name.required' => 'Department Name is required',
            'hod.required'  => 'Head of Department is required',
            'company.required'  => 'Company is required',
        ];
    }
}
