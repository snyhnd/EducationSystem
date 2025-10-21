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
            'name' => ['required','string','max:255','regex:/^[ぁ-んァ-ヶ一-龥a-zA-Z0-9ー・－\s]+$/u', ],
            'name_kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ヶー　]+$/u'], 
            'email' => ['required', 'string', 'email', 'min:8', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }

    public function messages()
    {
        return [
            //ユーザーネーム
            'name.required' => 'ユーザーネームは入力必須項目です',
            'name.max' => 'ユーザーネームは255文字以内で入力してください',
            'name.regex' => 'ユーザーネームを正しく入力してください', 

            //カナ
            'name_kana.required' => 'カナは入力必須項目です',
            'name_kana.max' => 'カナは255文字未満で入力してください',
            'name_kana.regex' => 'カナはカタカナで入力してください',

            //メール
            'email.required' => 'メールアドレスは入力必須項目です',
            'email.email' => 'メールアドレスはメールアドレス形式で入力してください',
            'email.min' => 'メールアドレスは8文字以上255文字以内で入力してください',
            'email.max' => 'メールアドレスは8文字以上255文字以内で入力してください',

            //画像
            'profile_image.image' => '指定されたファイル形式ではありません',
            'profile_image.mimes' => '指定されたファイル形式ではありません',
        ];
    }
}