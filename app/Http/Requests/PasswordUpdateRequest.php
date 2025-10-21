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
            'current_password' => ['required', 'string', 'min:8', 'max:20'],
            'new_password' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[a-zA-Z0-9]+$/'],
            'new_password_confirmation' => ['required', 'string', 'same:new_password', 'min:8', 'max:20', 'regex:/^[a-zA-Z0-9]+$/'],
        ];
    }

    public function messages()
    {
        return [
            // 現在のパスワード
            'current_password.required' => 'この項目は入力必須です',
            'current_password.min' => 'パスワードは8文字以上255文字以内で入力してください',
            'current_password.max' => 'パスワードは8文字以上255文字以内で入力してください',
            'current_password.regex' => '半角英数で入力してください',

            // 新しいパスワード
            'new_password.required' => '新パスワードは入力必須項目です',
            'new_password.min' => '新パスワードは8文字以上で入力してください',
            'new_password.max' => '新パスワードは255文字未満で入力してください',
            'new_password.regex' => '新パスワードは英数字で入力してください',

            // 確認用パスワード
            'new_password_confirmation.required' => 'この項目は入力必須です',
            'new_password_confirmation.same' => '新パスワードと一致しません',
            'new_password_confirmation.regex' => '新パスワードは英数字で入力してください',
        ];
    }

    /**
     * 現在のパスワード一致チェック
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 現在のユーザーを取得
            $user = $this->user();

            // 入力された現在のパスワード
            $currentPassword = $this->input('current_password');

            // 現在のパスワードが正しくない場合
            if (!Hash::check($currentPassword, $user->password)) {
                $validator->errors()->add('current_password', '現在設定されているパスワードと一致しません');
            }
        });
    }
}