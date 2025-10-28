@extends('layouts.app') {{-- 共通レイアウトを使う場合 --}}

@section('content')
<div class="container">
    <h2>ユーザー新規登録</h2>

    <form action="{{ url('/user/store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>名前</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label>フリガナ</label>
            <input type="text" name="name_kana" class="form-control" value="{{ old('name_kana') }}">
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label>プロフィール画像</label>
            <input type="file" name="profile_image" class="form-control">
        </div>

        <div class="form-group">
            <label>学年</label>
            <select name="grade_id" class="form-control">
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">登録する</button>
    </form>
</div>
@endsection
