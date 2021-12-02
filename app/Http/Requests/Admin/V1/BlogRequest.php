<?php

namespace App\Http\Requests\Admin\V1;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    private $requiredOrNot;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->requiredOrNot = $this->method() == 'PUT' ? 'nullable' : 'required';
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
            'thumb_nail' => $this->requiredOrNot . '|mimes:jpeg,png,gif,jpg',
            'title' => 'required',
            'url' => 'required',
            'active' => 'nullable|in:on',
            'about' => 'required'
        ];
    }
}
