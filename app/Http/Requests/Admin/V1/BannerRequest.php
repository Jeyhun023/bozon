<?php

namespace App\Http\Requests\Admin\V1;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    private $requiredOrNot;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->requiredOrNot = $this->method() == 'PUT' ? 'sometimes|nullable' : 'required';
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
            'main_image' => $this->requiredOrNot . '|mimes:jpeg,png,gif,jpg',
            'url' => 'required',
            'title' => 'nullable',
            'sira' => 'nullable',
        ];
    }
}
