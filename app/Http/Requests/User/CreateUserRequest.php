<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateUserRequest
 * @package App\Http\Requests\User
 */
class CreateUserRequest extends FormRequest
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
            'section' => '課程',
            'gender' => '性別',
            'blood_group' => '血型',
            'father_name' => '父親姓名',
            'mother_name' => '母親姓名',
            'phone_number' => '手機號碼',
            'address' => '地址',
            'session' => '學籍',
            'birthday' => '出生年月日'
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
            'name' => 'required|string|max:40',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'section' => 'required|numeric',
            'gender' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'session' => 'required',
            'birthday' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute必須填寫',
            'string' => ':attribute必須為文字',
            'numeric' => ':attribute必須為數字',
            'name.max' => '姓名最長不得大於 40 個字元',
            'email.max' => '信箱最長不得大於 255 個字元',
            'email' => ':attribute格式錯誤',
            'password.confirmed' => '密碼與確認密碼不同',
            'password.min' => '密碼至少 6 個字元(英文或數字)'
        ];
    }
}
