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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required',
            'blood_group' => 'required',
            'phone_number' => 'required|unique:users',
            'email' => 'email|max:255|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '姓名為必填欄位',
            'password.required'  => '密碼為必填欄位',
            'gender.required'  => '性別為必填欄位',
            'blood_group.required'  => '血型為必填欄位',
            'phone_number.required'  => '手機為必填欄位',
            'email.email' => '無效的信箱',
            'password.confirmed' => '密碼與確認密碼不符',
            'phone_number.unique' => '手機號碼已被登錄'
        ];
    }
}
