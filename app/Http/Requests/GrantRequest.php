<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GrantRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return [
                'employee_id' => 'required|unique:grants,employee_id',
                'program' => 'required',
                'course' => 'required',
                'status' => 'required|required_with:date_of_acceptance',
                'date_of_acceptance' => 'required_with:date_of_application',
                'date_of_application' => 'required_with:date_of_form_submission',
                'date_of_form_submission' => 'required_with:dos_loa',
                'dos_loa' => 'required_with:loajd',
                'loajd' => 'required_with:dos_jd',
                'dos_jd' => 'required_with:start_date',
                'start_date' => 'required_with:no_of_class',
                'no_of_class' => 'required_with:payment_due_date',
                'payment_due_date' => 'required_with:payment_date',
                'payment_date' => 'required_with:cheque_no',
                'cheque_no' => 'required_with:ojt_submit',
                'ojt_submit' => 'required_with:payment_due_date2',
            ];
        } else {
            return [
                'program' => 'required',
                'course' => 'required',
                'status' => 'required|required_with:date_of_acceptance',
                'date_of_acceptance' => 'required_with:date_of_application',
                'date_of_application' => 'required_with:date_of_form_submission',
                'date_of_form_submission' => 'required_with:dos_loa',
                'dos_loa' => 'required_with:loajd',
                'loajd' => 'required_with:dos_jd',
                'dos_jd' => 'required_with:start_date',
                'start_date' => 'required_with:no_of_class',
                'no_of_class' => 'required_with:payment_due_date',
                'payment_due_date' => 'required_with:payment_date',
                'payment_date' => 'required_with:cheque_no',
                'cheque_no' => 'required_with:ojt_submit',
                'ojt_submit' => 'required_with:payment_due_date2',
            ];
        }
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee Name is required',
            'employee_id.unique' => 'This employee had been attached to course already',
            'program.required' => 'Program is required',
            'course.required' => 'Course is required',
            'status.required_with' => 'Status is required',
            'date_of_acceptance.required_with' => 'Date of acceptance is required',
            'date_of_application.required_with' => 'Date of application is required',
            'date_of_form_submission.required_with' => 'Date of form submission is required',
            'dos_loa.required_with' => 'Date of submission (LOA) is required',
            'loajd.required_with' => 'Letter of acceptance job description is required',
            'dos_jd.required_with' => 'Date of submission (JD) is required',
            'start_date.required_with' => 'Start date is required',
            'no_of_class.required_with' => 'Number of Classes is required',
            'payment_due_date.required_with' => '1st Payment due date is required',
            'payment_date.required_with' => '1st Payment date is required',
            'cheque_no.required_with' => '1st Cheque Number is required',
            'ojt_submit.required_with' => '1st On the job training is required',
        ];
    }
}
