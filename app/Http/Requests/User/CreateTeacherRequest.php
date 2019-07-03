<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateTeacherRequest
 * @package App\Http\Requests\User
 */
class CreateTeacherRequest extends FormRequest
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
            'department_id' => '教師類別',
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
            'name' => 'required|string|max:20',
            'email' => 'sometimes|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required',
            'blood_group' => 'required',
            'department_id' => 'required|numeric',
            'phone_number' => 'required|unique:users',
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
