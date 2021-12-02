<?php

namespace App\Http\Requests\Api\V1\Order;


use App\Http\Requests\Api\FormRequest;

class PayDirectlyRequest extends FormRequest
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
            'first_name' => ['required', 'max:191'],
            'last_name' => ['required', 'max:191'],
            'phone' => ['required', 'min:9', 'max:191'],
            'city' => ['required', 'integer', 'exists:cities,id'],
            'address' => ['max:1500'],
            'payment_type' => ['required', 'in:cash,online'],
        ];
    }
}
