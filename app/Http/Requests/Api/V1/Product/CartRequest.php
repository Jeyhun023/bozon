<?php

namespace App\Http\Requests\Api\V1\Product;


use App\Http\Requests\Api\FormRequest;

class CartRequest extends FormRequest
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
            'product_id' => 'sometimes|required',
            'item_id' => 'sometimes|required',
            'quantity' => 'required|numeric|min:1'
        ];
    }

    public function attributes()
    {
        return [
            'product_id' => 'Item',
            'quantity' => 'Say',
        ];
    }
}
