<?php

namespace App\Http\Requests\Api\V1\Auth;


use App\Http\Requests\Api\FormRequest;

class CheckVerificationRequest extends FormRequest
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
            'phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|max:20',
            'code' => 'required|numeric|digits_between:1,6',
            'token_type' => 'required|in:0,1'
        ];
    }
}
