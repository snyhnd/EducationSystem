<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class PasswordUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password' => ['required', 'string', 'min:8', 'max:30'],
            'new_password' => ['required', 'string', 'min:8', 'max:30', 'regex:/^[a-zA-Z0-9]+$/'],
            'new_password_confirmation' => ['required', 'string', 'same:new_password', 'min:8', 'max:30', 'regex:/^[a-zA-Z0-9]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'この項目は入力必須です',
            'current_password.min' => 'パスワードは8文字以上30文字以内で入力してください',
            'current_password.max' => 'パスワードは8文字以上30文字以内で入力してください',
            'current_password.regex' => '半角英数で入力してください',
            'new_password.required' => 'この項目は入力必須です',
            'new_password.min' => 'パスワードは8文字以上30文字以内で入力してください',
            'new_password.max' => 'パスワードは8文字以上30文字以内で入力してください',
            'new_password.regex' => '半角英数で入力してください',
            'new_password_confirmation.required' => 'この項目は入力必須です',
            'new_password_confirmation.same' => '入力したパスワードと異なります',
            'new_password_confirmation.regex' => '半角英数で入力してください',
        ];
    }
}