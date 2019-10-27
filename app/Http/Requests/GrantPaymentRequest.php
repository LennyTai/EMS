<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrantPaymentRequest extends FormRequest
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
            'payment_no' => 'required',
            'payment_due_date' => 'required',
            'payment_date' => 'required_with:cheque_no' .(empty($this->payment_date) ?: '|after_or_equal:payment_due_date'),
            'cheque_no' => 'required_with:ojt_submit',
            'ojt_submit' => 'required_with:payment_due_date2',
        ];
    }

    public function messages()
    {
        return [
            'payment_no.required' => 'Payment number is required',
            'payment_due_date.required' => 'Payment due date is required',
            'payment_date.required_with' => '1st Payment date is required',
            'cheque_no.required_with' => '1st Cheque Number is required',
            'ojt_submit.required_with' => '1st On the job training is required',
        ];
    }
}
