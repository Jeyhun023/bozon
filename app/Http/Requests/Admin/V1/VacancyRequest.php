<?php

namespace App\Http\Requests\Admin\V1;

use Illuminate\Foundation\Http\FormRequest;

class VacancyRequest extends FormRequest
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
            'position' => 'required',
            'email' => 'required',
            'active' => 'nullable|in:on',
            'sira' => 'nullable',
            'dead_line' => 'nullable|after:today',
            'about' => 'required',
        ];
    }
}
