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
            'nationality' => '國籍',
            'father_name' => '父親姓名',
            'mother_name' => '母親姓名',
            'phone_number' => '手機號碼',
            'address' => '地址',
            'session' => '學籍',
            'version' => '語言',
            'birthday' => '出生年月日',
            'religion' => '宗教',
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
            'name' => 'required|string|max:20',
            'email' => 'sometimes|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'section' => 'required|numeric',
            'gender' => 'required|string',
            'blood_group' => 'required|string',
            'nationality' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'phone_number' => 'required|string|unique:users',
            'address' => 'required|string',
            'session' => 'required',
            'version' => 'required',
            'birthday' => 'required',
            'religion' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute必須填寫',
            'string' => ':attribute必須為文字',
            'numeric' => ':attribute必須為數字',
            'name.max' => '姓名最長不得大於 20 個字元',
            'email.max' => '信箱最長不得大於 255 個字元',
            'email' => ':attribute格式錯誤',
            'password.confirmed' => '密碼與確認密碼不同',
            'password.min' => '密碼至少 6 個字元(英文或數字)',
            'email.unique' => '信箱已經存在',
            'phone_number.unique' => '手機號碼已存在'
        ];
    }
}
