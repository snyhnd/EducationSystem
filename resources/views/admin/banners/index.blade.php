<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>バナー管理</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{ background:#f7f9fb; }
    .app-header{
      background:#66e0f0; color:#fff;
      border-radius:12px; padding:14px 18px; margin:24px 0 18px;
      display:flex; align-items:center; justify-content:space-between;
    }
    .app-header .btn{ border:none; font-weight:600; }
    .btn-group .btn{ margin-right:10px; }
    .btn-group .btn:last-child{ margin-right:0; }
    .page-title{ font-weight:700; margin:12px 0 18px; }
    .banner-card{
      display:flex; align-items:center; gap:16px;
      padding:14px; background:#fff; border-radius:12px;
      box-shadow:0 6px 16px rgba(0,0,0,.06);
    }
    .banner-thumb{
      width:180px; height:110px; object-fit:cover; border-radius:8px;
      background:#eee;
    }
    .minus-btn{
      width:36px; height:36px; border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      background:#ff3b30; color:#fff; border:none; font-size:22px;
      line-height:1; font-weight:700;
    }
    .minus-btn:disabled{ opacity:.4; }
    .hint{ color:#6c757d; font-size:.9rem; }
  </style>
</head>
<body>
<div class="container py-3">

  {{-- ヘッダー（設計シートの水色バー） --}}
  <div class="app-header">
    <div class="btn-group">
      <a href="{{ url('/timetable') }}" class="btn btn-info text-white">授業管理</a>
      <a href="#" class="btn btn-secondary text-white">お知らせ管理</a>
      <a href="{{ route('admin.banners.index') }}" class="btn btn-primary">バナー管理</a>
    </div>
    <a href="{{ url('/admin') }}" class="text-white fw-bold text-decoration-none">ログアウト</a>
  </div>

  <a href="{{ url()->previous() }}" class="d-inline-block mb-2">&larr; 戻る</a>
  <h2 class="page-title">バナー管理</h2>

  {{-- ▼ 一覧（3枠を並べる。DBなくてもダミーで表示） --}}
  @php
    // DBが無い間のダミー3枠（画像はプレースホルダ）
    $placeholders = [
      'https://placehold.co/360x220?text=Banner+1',
      'https://placehold.co/360x220?text=Banner+2',
      'https://placehold.co/360x220?text=Banner+3',
    ];
    // DB接続後は $banners（URL配列）に置き換え可能
    $rows = count($banners) ? $banners : collect($placeholders)->map(fn($u)=>['url'=>$u]);
  @endphp

  <div class="vstack gap-3 mb-4">
    @foreach($rows as $row)
      <div class="banner-card">
        <img src="{{ $row['url'] }}" alt="banner" class="banner-thumb">
        <div class="flex-grow-1">
          <input type="file" class="form-control" disabled>
          <span class="hint d-block mt-1">※ ここは見た目だけ。登録は後で実装します</span>
        </div>
        <button class="minus-btn" title="削除" disabled>−</button>
      </div>
    @endforeach
  </div>

  {{-- 下部：追加ボタン（見た目のみ） --}}
  <div class="d-flex gap-2">
    <button class="btn btn-outline-primary" disabled>追加</button>
    <button class="btn btn-success" disabled>登録</button>
  </div>
  <p class="hint mt-2">まずはトップ画面のUIだけ完成。アップロード/削除の動作はDB準備後に有効化します。</p>

</div>

</body>
</html>
