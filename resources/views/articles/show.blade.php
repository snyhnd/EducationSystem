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

    /* ==== お知らせ詳細部分 ==== */
    .article-container {
        width: 80%;
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

    .article-date {
        color: #555;
        margin-bottom: 10px;
    }

    .article-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 30px;
        color: #333;
    }

    .article-description {
        font-size: 18px;
        margin-bottom: 30px;
        color: #333;
    }

    .article-body {
        font-size: 18px;
        line-height: 1.8;
        color: #222;
        white-space: pre-wrap;
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

{{-- ====== 本文部分 ====== --}}
<div class="article-container">

    {{-- 戻るリンク --}}
    <a href="{{ url()->previous() }}" class="back-link">←戻る</a>

    {{-- 投稿日時 --}}
    <p class="date">
        {{ \Carbon\Carbon::parse($article->posted_date)->format('Y年n月j日') }}
    </p>

    {{-- タイトル --}}
    <h1>{{ $article->title }}</h1>

    {{-- 本文 --}}
    <div class="contents">
        {!! nl2br(e($article->article_contents)) !!}
    </div>

</div>
@endsection