<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\User
 */
class UpdateUserRequest extends FormRequest
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
            'user_id' => '使用者 id',
            'email' => '電子信箱',
            'name' => '姓名',
            'phone_number' => '手機號碼',
            'department_id' => '部門 ID'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'email' => 'required|email|max:255|' . Rule::unique('users')->ignore($this->get('user_id')),
            'name' => 'required|string|max:20',
            'phone_number' => 'required|string|' . Rule::unique('users')->ignore($this->get('user_id')),
        ];

        if ($this->get('user_role') == 'teacher') {
            $rules['department_id'] = 'required|numeric';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute必須填寫',
            'string' => ':attribute必須為文字',
            'numeric' => ':attribute必須為數字',
            'email' => '電子信箱格式錯誤',
            'email.unique' => '電子信箱已存在',
            'name.max' => '姓名不得超過 20 字元'
        ];
    }
}
