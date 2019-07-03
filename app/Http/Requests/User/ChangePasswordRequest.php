<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ChangePasswordRequest
 * @package App\Http\Requests\User
 */
class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
        ];
    }

    public function messages()
{
    return [
        'old_password.required' => '請填寫舊密碼',
        'old_password.min' => '舊密碼不得少於 :min 個字元',
        'new_password.required'  => '請填寫新密碼',
        'new_password.min'  => '新密碼不得少於 :min 個字元'
    ];
}
}
