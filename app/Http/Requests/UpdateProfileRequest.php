<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'name_kana' => ['required', 'string', 'max:20', 'regex:/^[ァ-ヶー　]+$/u'], // 全角カタカナ
            'email' => ['required', 'string', 'email', 'min:8', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }

    public function messages()
    {
        return [
            //ユーザーネーム
            'name.required' => 'この項目は入力必須です',
            'name.max' => '20文字以内にしてください',

            //カナ
            'name_kana.required' => 'この項目は入力必須です',
            'name_kana.max' => '20文字以内にしてください',
            'name_kana.regex' => 'カタカナで入力してください',

            //メール
            'email.required' => 'この項目は入力必須です',
            'email.email' => 'メールアドレスの形式で入力してください',
            'email.min' => 'メールアドレスは8文字以上255文字以内で入力してください',
            'email.max' => 'メールアドレスは8文字以上255文字以内で入力してください',

            //画像
            'profile_image.image' => '指定されたファイル形式ではありません',
            'profile_image.mimes' => '指定されたファイル形式ではありません',
        ];
    }
}