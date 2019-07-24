<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateAdminRequest
 * @package App\Http\Requests\User
 */
class CreateAdminRequest extends FormRequest
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

    public function attributes()
    {
        return [
            'name' => '姓名',
            'email' => '電子信箱',
            'password' => '密碼',
            'gender' => '性別',
            'blood_group' => '血型',
            'phone_number' => '手機號碼'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required',
            'phone_number' => 'required',
            'email' => 'email|max:255',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute必須填寫',
            'email.email' => '電子信箱格式錯誤',
            'password.confirmed' => '密碼與確認密碼不符',
            'phone_number.unique' => '手機號碼已存在',
            'email.unique' => '電子信箱已存在',
            'email.max' => '電子信箱不得超過 255 個字元',
            'name.max' => '姓名不得超過 50 個字元',
            'password.min' => '密碼不得少於 6 個字元',
        ];
    }
}
