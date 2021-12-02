<?php

namespace App\Http\Requests\Api\V1\Auth;


use App\Http\Requests\Api\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->merge([
            'ip_address' => $this->ip(),
            'customer_code' => strtoupper(uniqid())
        ]);
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
            'phone_number' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|max:20|unique:users,phone_number',
            'full_name' => 'required|max:60',
            'password' => 'required|min:6',
            'user_type' => 'required|in:buyer,seller'
        ];
    }

    public function attributes()
    {
        return [
            'phone_number' => 'Mobil nömrə',
            'full_name' => 'Ad, Soyad',
            'password' => 'şifrə'
        ];
    }
}
