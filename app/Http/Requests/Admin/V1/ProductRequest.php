<?php

namespace App\Http\Requests\Admin\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            //'p_id' => 'required|exists:products,id',
            'title' => 'required|string',
            'description' => 'string|nullable|max:10000',
            'meta.*' => 'required|string',
            'thumbnail' => ['nullable'], ['mimes:jpeg,bmp,png,svg'],
            'category' => 'required|exists:categories,id',
            'brand' => 'required|exists:brands,id',
            'colors.*' => 'required',
            'price' => 'required',
            'qty' => 'required|integer',
            'discount' => 'nullable',
            'discount_type' => 'in:1,2|nullable',
            //'attributes.*' => '',
            //'variations.*' => '',
            //'prices.*' => '',
            //'skus.*' => '',
            //'qtys.*' => '',
        ];
    }
}
