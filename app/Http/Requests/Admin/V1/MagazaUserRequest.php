<?php

namespace App\Http\Requests\Admin\V1;

use Illuminate\Foundation\Http\FormRequest;

class MagazaUserRequest extends FormRequest
{
    private $requiredOrNot;
    private $for_username;
    private $for_user_id;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->requiredOrNot = $this->method() == 'PUT' ? 'nullable' : 'required';
        $this->for_user_id = $this->method() == 'POST' ? 'nullable' : 'required|integer';
        $this->for_username = 'required|unique:users,email,' . $this->user_id;
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
            'user_id' => $this->for_user_id,
            'full_name' => 'required|max:255',
            'password_other' => 'nullable|max:255',
            'username' => $this->for_username,
            'password' => $this->requiredOrNot . '|min:6|max:255|confirmed',
            'thumb_nail' => $this->requiredOrNot . '|mimes:jpeg,png,gif,jpg',
            'logo' => $this->requiredOrNot . '|mimes:jpeg,png,gif,jpg',
            'url' => 'required',
            'active' => 'nullable|in:on',
            'about' => 'required'
        ];
    }
}
