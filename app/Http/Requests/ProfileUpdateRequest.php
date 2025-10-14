<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'profile_image' => 'nullable|file|mimes:jpg,jpeg,png',
            'name' => 'required|string|min:1|max:20',
            'name_kana' => ['required', 'string', 'min:1', 'max:20', 'regex:/^[ァ-ヶー]+$/u'],
            'email' => 'required|string|email|max:255',
        ];
    }

    public function messages()
    {
        return [
            'profile_image.mimes' => '指定されたファイル形式ではありません',
            'name.required' => 'この項目は入力必須です',
            'name.max' => '20文字以内にしてください',
            'name_kana.required' => 'この項目は入力必須です',
            'name_kana.regex' => 'カタカナで入力してください',
            'name_kana.max' => '20文字以内にしてください',
            'email.required' => 'この項目は入力必須です',
            'email.email' => '半角英数で入力してください',
            'email.max' => '255文字以内にしてください',
        ];
    }
}
