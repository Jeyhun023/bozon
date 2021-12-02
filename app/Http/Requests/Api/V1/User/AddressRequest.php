<?php

namespace App\Http\Requests\Api\V1\User;


use App\Http\Requests\Api\FormRequest;

class AddressRequest extends FormRequest
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
            'title' => 'required|max:50',
            'address' => 'required|max:100',
            'full_address' => 'nullable|max:255',
            'zip_code' => 'nullable|max:20',
            'user_name' => 'required|max:60',
            'city_id' => 'required|exists:cities,id',
            'phone_number' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|max:20',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Başlıq',
            'city_id' => 'Şəhər',
            'address' => 'Ünvan',
            'full_address' => 'Tam ünvan',
            'user_name' => 'İstifadəçi adı',
            'phone_number' => 'Telefon nömrəsi',
        ];
    }
}
