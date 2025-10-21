@extends('layouts.app')

@section('content')
<style>
    /* ===== オレンジヘッダー ===== */
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

    .nav-left { display: flex; gap: 15px; }

    .nav-left a {
        background-color: #12b0b0;
        color: #fff;
        padding: 10px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
    }

    .nav-left a.active { background-color: #0c8a8a; }

    .logout {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        font-size: 18px;
    }

    .logout:hover { text-decoration: underline; }

    /* ===== メイン ===== */
    .profile-container {
        width: 80%;
        margin: 40px auto;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
    }

    .back-link:hover { text-decoration: underline; }

    h2 { font-size: 30px; margin-bottom: 25px; }

    .image-upload-section {
        display: flex;
        align-items: center;
        margin-bottom: 40px;
    }

    .image-upload-section img {
        width: 100px;
        height: 100px;
        border-radius: 5px;
        object-fit: cover;
        margin-right: 25px;
        background-color: #f1f1f1;
    }

    form {
        width: 70%;
        margin: 0 auto;
    }

    .form-group {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-bottom: 10px;
    }

    .form-group label {
        width: 150px;
        font-weight: bold;
        font-size: 18px;
    }

    .form-group input {
        flex: 1;
        height: 35px;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 16px;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-left: 150px;
        margin-bottom: 10px;
    }

    .register-btn {
        display: block;
        margin: 40px auto 0;
        background-color: #EF6C43;
        color: #fff;
        font-weight: bold;
        border: none;
        padding: 10px 40px;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
    }

    .password-btn {
        background-color: #fff;
        border: 1px solid #666;
        padding: 5px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        margin-left: 0;
        width: 200px;
        text-align: center;
    }

    .password-btn:hover {
        background-color: #f3f3f3;
    }

    /* ファイル選択カスタマイズ部分  */
    .custom-file {
        position: relative;
        display: inline-block;
        overflow: hidden;
    }

    .custom-file input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .custom-file-label {
        display: inline-block;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 6px 12px;
        cursor: pointer;
    }

    .file-name {
        margin-left: 10px;
        color: #666;
    }

    .file-name.hidden {
        display: none;
    }
</style>

<div class="sub-header">
    <div class="nav-left">
        <a href="{{ route('schedule.index') }}">時間割</a>
        <a href="{{ route('progress.index') }}">授業進捗</a>
        <a href="{{ route('profile.edit') }}" class="active">プロフィール設定</a>
    </div>

    <a href="{{ route('logout') }}" class="logout"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ログアウト
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>

<div class="profile-container">
    <a href="{{ route('top') }}" class="back-link">← 戻る</a>
    <h2>プロフィール変更</h2>

    @if(session('success'))
        <div class="alert alert-success" style="color:green;">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"novalidate>
        @csrf
        @method('PUT')

        {{-- 画像 --}}
        <div class="image-upload-section">
            <img id="preview" src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('images/sample-avatar.png') }}" alt="プロフィール画像">
            <div>
                <label for="profile_image">プロフィール画像</label><br>
                <div class="custom-file">
                    <label class="custom-file-label" for="profile_image">ファイルを選択</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/png, image/jpeg, image/jpg, image/gif, image/webp">
                    <span id="file-name" class="file-name {{ $user->profile_image ? 'hidden' : '' }}">選択されていません</span>
                </div>
                @error('profile_image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- ユーザーネーム --}}
        <div class="form-group">
            <label for="name">ユーザーネーム</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
        </div>
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- カナ --}}
        <div class="form-group">
            <label for="name_kana">カナ</label>
            <input type="text" id="name_kana" name="name_kana" value="{{ old('name_kana', $user->name_kana) }}">
        </div>
        @error('name_kana')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- メールアドレス --}}
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
        </div>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- パスワード変更 --}}
        <div class="form-group">
            <label>パスワード</label>
            <button type="button" class="password-btn" onclick="location.href='{{ route('profile.password') }}'">パスワードを変更する</button>
        </div>

        <button type="submit" class="register-btn">登録</button>
    </form>
</div>

{{-- ===== JS: プレビュー & バリデーション機能 ===== --}}
<script>
    const input = document.getElementById('profile_image');
    const fileName = document.getElementById('file-name');
    const preview = document.getElementById('preview');

    input.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            // 画像ファイルでなければ警告を出してリセット
            if (!file.type.startsWith('image/')) {
                alert('プロフィール画像は、画像ファイルを選択してください');
                this.value = ''; // ファイル選択リセット
                fileName.textContent = '選択されていません';
                fileName.classList.remove('hidden');
                preview.src = "{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('images/sample-avatar.png') }}";
                return;
            }

            // ファイル名表示
            fileName.textContent = file.name;
            fileName.classList.remove('hidden');

            // プレビュー更新
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = '選択されていません';
            fileName.classList.remove('hidden');
        }
    });
</script>
@endsection