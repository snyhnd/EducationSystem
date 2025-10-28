@extends('user.layouts.app')

@section('title', 'ログイン')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>ログイン</h2>
        <a href="{{ route('user_register') }}" class="text-primary">新規会員登録はこちら</a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('user_login') }}">
        @csrf

        {{-- メールアドレス --}}
        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        {{-- パスワード --}}
        <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        {{-- ログインボタン --}}
        <button type="submit" class="btn btn-primary">ログイン</button>

    </form>
@endsection
