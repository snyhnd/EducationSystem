@extends('user.layouts.app')

@section('title', '新規会員登録')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>新規会員登録</h2>
        <a href="{{ route('user_login') }}" class="text-primary">ログインはこちら</a>
    </div>

    {{-- バリデーションエラー表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 登録フォーム --}}
    <form method="POST" action="{{ route('user_register') }}">
        @csrf

        {{-- ユーザー名 --}}
        <div class="mb-3">
            <label for="name" class="form-label">ユーザー ネーム</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" >
        </div>

        {{-- カナ --}}
        <div class="mb-3">
            <label for="kana" class="form-label">カナ</label>
            <input type="text" name="kana" id="kana" value="{{ old('kana') }}" class="form-control" >
        </div>

        {{-- メールアドレス --}}
        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" >
        </div>

        {{-- パスワード --}}
        <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        {{-- パスワード確認 --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">パスワード確認</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        {{-- 登録ボタン --}}
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection
