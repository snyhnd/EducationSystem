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
        padding: 8px 40px; /* 高さをスリムに */
        width: 90%; /* 横幅を短く調整 */
        margin: 20px auto; /* 中央寄せ */
        border-radius: 10px; /* 両端を少し丸く */
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    /* ===== ナビゲーションボタン ===== */
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

    /* ===== ログアウトリンク ===== */
    .logout { color: #fff; text-decoration: none; font-weight: bold; font-size: 18px; }
    .logout:hover { text-decoration: underline; }

    /* ===== メインコンテンツ ===== */
    .content-container { width: 85%; margin: 30px auto; }

    .back-link {
        display: inline-block; margin-bottom: 15px; color: #333;
        text-decoration: none; font-weight: bold;
    }
    .back-link:hover { text-decoration: underline; }

    h2 { font-size: 32px; margin-bottom: 25px; }

    /* ===== 新規登録ボタン ===== */
    .btn-new {
        display: inline-block; background-color: #088F91; color: #fff;
        padding: 10px 18px; border-radius: 5px; font-weight: bold;
        text-decoration: none; transition: 0.3s; margin-bottom: 25px;
    }
    .btn-new:hover { opacity: 0.8; }

    /* ===== テーブルスタイル ===== */
    table { width: 100%; border-collapse: collapse; }
    th, td { text-align: left; padding: 15px; font-size: 18px; vertical-align: middle; }
    th { font-weight: bold; border-bottom: none; }
    td { border-bottom: none; }
    th.actions, td.actions { width: 220px; white-space: nowrap; }

    /* ===== ボタン ===== */
    .btn-edit {
        background-color: #1b7c7c; color: #fff; padding: 6px 12px;
        border: none; border-radius: 4px; cursor: pointer; font-weight: bold;
        text-decoration: none;
    }
    .btn-edit:hover { background-color: #146060; }

    .btn-delete {
        background-color: #E53935; color: #fff; padding: 6px 12px;
        border: none; border-radius: 4px; cursor: pointer; font-weight: bold;
        margin-left: 5px;
    }
    .btn-delete:hover { background-color: #b00000; }

    .inline-form { display: inline; }
    .flash { padding: 10px 14px; border-radius: 6px; margin: 12px 0; }
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
    <a href="{{ route('admin.top') }}" style="color: black; text-decoration: none;">&larr; 戻る</a>
    <h2>お知らせ一覧</h2>

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

    <a href="{{ route('admin.articles.create') }}" class="btn-new">新規登録</a>

    <table>
        <thead>
            <tr>
                <th>投稿日</th>
                <th>タイトル</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($articles as $article)
                <tr>
                    <td>
                        @if ($article->posted_date)
                            {{ \Carbon\Carbon::parse($article->posted_date)->format('Y年n月j日') }}
                        @else
                            未設定
                        @endif
                    </td>
                    <td>{{ $article->title }}</td>
                    <td class="actions">
                        {{-- 変更する → /admin/articles/{id}/edit --}}
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn-edit">変更する</a>

                        {{-- 削除（確認ダイアログ付き） --}}
                        <form action="{{ route('admin.articles.destroy', $article->id) }}"
                              method="POST" class="inline-form"
                              onsubmit="return confirm('※{{ $article->title }} を削除してよろしいですか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">登録されたお知らせはありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection