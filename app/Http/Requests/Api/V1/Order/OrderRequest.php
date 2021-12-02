<?php

namespace App\Http\Requests\Api\V1\Order;


use App\Http\Requests\Api\FormRequest;

class OrderRequest extends FormRequest
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
        $validationRules = [];

        if (auth('api')->check()){
            $validationRules = [
                'address' => ['required', 'integer', 'exists:user_addresses,id']
            ];
        } else {
            $validationRules = [
                'products' => ['required'],
                'products.*.id' => ['required', 'integer', 'exists:products,id'],
                'products.*.qty' => ['required', 'integer'],
                'products.*.attributes' => ['required', 'string'],
                'fullname' => ['required', 'string'],
                'phone' => ['required', 'string'],
                'city_id' => ['required', 'integer', 'exists:cities,id'],
                'address' => ['required', 'string'],
            ];
        }
        $validationRules['payment_type'] = ['required'];
        return $validationRules;
    }

    public function messages()
    {
        return [
            'products.required' => 'Səbətinizdə minimum 1 məhsul olmalıdır!',
        ];
    }

    public function attributes()
    {
        return [
            'city_id' => 'Şəhər',
            'address' => 'Ünvan',
            'fullname' => 'İstifadəçi adı',
            'phone' => 'Telefon nömrəsi',
        ];
    }
}
