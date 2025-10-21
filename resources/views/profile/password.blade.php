@extends('layouts.app')

@section('content')
<style>
    /* ==== オレンジヘッダー ==== */
    .sub-header {
        background-color: #EF6C43;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 40px;
        border-radius: 10px;
        width: 80%;
        margin: 30px auto 0;
    }

    .nav-left {
        display: flex;
        gap: 15px;
    }

    .nav-left a {
        background-color: #12b0b0;
        color: #fff;
        padding: 10px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    .nav-left a:hover {
        background-color: #0c8a8a;
    }

    .logout {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        font-size: 18px;
    }

    .logout:hover {
        text-decoration: underline;
    }

    /* ==== メイン部分 ==== */
    .password-container {
        width: 60%;
        margin: 40px auto;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .password-title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 40px;
        color: #222;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 25px;
    }

    .form-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 600px;
    }

    .form-group label {
        width: 150px;
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .form-group input {
        width: 400px;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #999;
        border-radius: 4px;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: 4px;
        text-align: right;
        width: 100%;
    }

    .submit-btn {
        background-color: #EF6C43;
        color: white;
        padding: 10px 40px;
        border: none;
        border-radius: 4px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 20px;
    }

    .submit-btn:hover {
        background-color: #d85934;
    }
</style>

{{-- ==== オレンジヘッダー ==== --}}
<div class="sub-header">
    <div class="nav-left">
        <a href="{{ route('schedule.index') }}">時間割</a>
        <a href="{{ route('progress.index') }}">授業進捗</a>
        <a href="{{ route('profile.edit') }}">プロフィール設定</a>
    </div>

    <a href="{{ route('logout') }}" class="logout"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ログアウト
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>

{{-- ==== パスワード変更フォーム ==== --}}
<div class="password-container">
    <a href="{{ route('profile.edit') }}" class="back-link">← 戻る</a>

    <h2 class="password-title">パスワード変更</h2>

    <form action="{{ route('profile.password.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="current_password">旧パスワード</label>
            <input type="password" id="current_password" name="current_password">
        </div>
        @error('current_password')
            <div class="error">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="new_password">新パスワード</label>
            <input type="password" id="new_password" name="new_password">
        </div>
        @error('new_password')
            <div class="error">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="new_password_confirmation">新パスワード確認</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation">
        </div>
        @error('new_password_confirmation')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="submit-btn">登録</button>
    </form>
</div>
@endsection