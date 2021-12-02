<?php

namespace App\Http\Requests\Api\V1\User;


use App\Http\Requests\Api\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'full_name' => 'sometimes|max:60',
            'phone_number' => 'sometimes|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|max:20|unique:users,phone_number,'.auth('api')->user()->id,
            'email' => 'sometimes|unique:users,email,'.auth('api')->user()->id,
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function attributes()
    {
        return [
            'phone_number' => 'Mobil nömrə',
            'full_name' => 'Ad, Soyad',
            'email' => 'Email',
            'photo' => 'Şəkil'
        ];
    }
}
