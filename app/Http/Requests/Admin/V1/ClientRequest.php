<?php

namespace App\Http\Requests\Admin\V1;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ClientRequest extends FormRequest
{
    private $requiredOrNot;
    private $phoner;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->merge([
            'phone_number' => !is_null($this->phone_number) ? $this->phone_prefix . $this->phone_number : null
        ]);
        $this->phoner = $this->phone ? 'required_if:phone_number,!=,null' : 'nullable';
//        $this->phone=!is_null($this->phone) ? $this->phone_prefix.$this->phone : null
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
            'full_name' => 'required|max:191',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'phone_prefix' => $this->phoner,
            'phone_number' => $this->requiredOrNot . '|numeric|unique:users,phone_number',
            'password' => $this->requiredOrNot . '|min:6|max:191'
        ];
    }
}
