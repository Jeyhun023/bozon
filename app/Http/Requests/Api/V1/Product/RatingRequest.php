<?php

namespace App\Http\Requests\Api\V1\Product;


use App\Http\Requests\Api\FormRequest;

class RatingRequest extends FormRequest
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
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'product_rate' => 'required|integer|max:5',
            'seller_rate' => 'required|integer|max:5',
            'note' => 'nullable|max:255'
        ];
    }

    public function attributes()
    {
       return [
           'order_id' => 'Sifariş',
           'product_id' => 'Məhsul',
           'product_rate' => 'Məhsul rəyi',
           'seller_rate' => 'Mağaza rəyi',
           'note' => 'Şərh',
       ];
    }
}
