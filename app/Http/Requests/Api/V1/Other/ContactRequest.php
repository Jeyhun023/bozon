<?php

namespace App\Http\Requests\Api\V1\Other;


use App\Http\Requests\Api\FormRequest;

class ContactRequest extends FormRequest
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
            'full_name' => 'required|max:255',
            'topic' => 'required|max:255',
            'message' => 'required',
        ];
    }

    public function attributes()
    {
       return [
           'full_name' => 'Ad, Soyad',
           'topic' => 'Mövzü',
           'message' => 'Mesaj',
       ];
    }
}
