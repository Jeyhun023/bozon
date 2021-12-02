<?php

namespace App\Http\Requests\Api\V1\User;


use App\Http\Requests\Api\FormRequest;
use App\Rules\MatchOldPassword;

class UserPasswordUpdateRequest extends FormRequest
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
            'current_password' => ['required', new MatchOldPassword],
            'password' => ['required','min:6'],
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => 'İndiki şifrə',
            'password' => 'Yeni şifrə'
        ];
    }
}
