<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
        if (! app()->runningInConsole()) {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->id.',id',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'role' => 'nullable|string|exists:roles,name',
        ];
        }
    }
}
