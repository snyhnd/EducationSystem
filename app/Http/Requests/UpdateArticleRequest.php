<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'article_contents' => 'required',
            'posted_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須項目です。',
            'article_contents.required' => '本文は必須項目です。',
            'posted_date.required' => '投稿日時は必須項目です。',
            'posted_date.date' => '投稿日時の形式が正しくありません。',
        ];
    }
}