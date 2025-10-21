@extends('layouts.app')

@section('content')
<style>
    /* ===== 管理画面ヘッダー（水色バナー） ===== */
    .admin-header {
        background-color: #4fd8e8;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 40px;
        width: 90%;
        margin: 20px auto;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .nav-left { display: flex; gap: 15px; }
    .nav-left a {
        background-color: #666;
        color: #fff;
        padding: 8px 22px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }
    .nav-left a:hover { background-color: #555; }
    .nav-left a.active { background-color: #444; }

    .logout { color: #fff; text-decoration: none; font-weight: bold; font-size: 18px; }
    .logout:hover { text-decoration: underline; }

    .content-container { width: 80%; margin: 30px auto; }
    .back-link {
        display: inline-block; margin-bottom: 15px;
        color: #333; text-decoration: none; font-weight: bold;
    }
    .back-link:hover { text-decoration: underline; }

    h2 { font-size: 32px; margin-bottom: 30px; }

    form { width: 100%; max-width: 900px; margin: 0 auto; }
    .form-group {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
        gap: 20px;
    }

    .form-group label {
        width: 150px;
        font-size: 20px;
        font-weight: bold;
        margin-top: 8px;
    }

    .form-group input[type="text"],
    .form-group input[type="datetime-local"],
    .form-group textarea {
        flex: 1;
        padding: 10px 12px;
        border: 1px solid #aaa;
        border-radius: 4px;
        font-size: 16px;
        background-color: #fff;
    }

    .form-group textarea {
        height: 150px;
        resize: vertical;
    }

    .btn-submit {
        display: block;
        background-color: #555;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 30px;
        font-size: 18px;
        font-weight: bold;
        margin: 40px auto 0;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit:hover { background-color: #333; }

    .flash { padding: 10px 14px; border-radius: 6px; margin-bottom: 20px; }
    .flash.success { background: #e6ffed; color: #0a6b2e; }
    .flash.error { background: #ffecec; color: #a40000; }
</style>

{{-- ===== 管理ヘッダー部分 ===== --}}
<div class="admin-header">
    <div class="nav-left">
        <a href="{{ route('admin.dashboard') }}">授業管理</a>
        <a href="{{ route('admin.articles.index') }}" class="active">お知らせ管理</a>
        <a href="{{ route('admin.banners.index') }}">バナー管理</a>
    </div>

    <a href="{{ route('logout') }}" class="logout"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ログアウト
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>

{{-- ===== メインコンテンツ ===== --}}
<div class="content-container">
    <a href="{{ route('admin.articles.index') }}" class="back-link">← 戻る</a>
    <h2>
        {{ isset($article->id) ? 'お知らせ変更' : 'お知らせ変更' }}
    </h2>

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
        <div class="flash success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="flash error">
            @foreach ($errors->all() as $error)
                <div>・{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- ===== 共通フォーム ===== --}}
    <form action="{{ isset($article->id)
        ? route('admin.articles.update', $article->id)
        : route('admin.articles.store') }}"
        method="POST">

        @csrf
        @if (isset($article->id))
            @method('PUT')
        @endif

        {{-- 投稿日時 --}}
        <div class="form-group">
            <label for="posted_date">投稿日時</label>
            <input type="datetime-local" id="posted_date" name="posted_date"
                   value="{{ old('posted_date', isset($article->posted_date) ? \Carbon\Carbon::parse($article->posted_date)->format('Y-m-d\TH:i') : '') }}">
        </div>

        {{-- タイトル --}}
        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" id="title" name="title"
                   value="{{ old('title', $article->title ?? '') }}">
        </div>

        {{-- 本文 --}}
        <div class="form-group">
            <label for="article_contents">本文</label>
            <textarea id="article_contents" name="article_contents">{{ old('article_contents', $article->article_contents ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn-submit">
            {{ isset($article->id) ? '登録する' : '登録する' }}
        </button>
    </form>
</div>
@endsection