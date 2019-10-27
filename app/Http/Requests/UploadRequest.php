<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
            'filename' => 'required|mimes:jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'filename.mimes' => 'Invalid format, the attachment must be either jpeg,png,jpg,zip,pdf,ppt,pptx,doc,docx,xls,xlsx',
            'filename.required' => 'No attachment to upload',
            'filename.max' => 'The attachment may not be greater than 1mb'
        ];
    }
}
