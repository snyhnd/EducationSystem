<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>管理トップ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root {
      --cyan:#45d9e7;   /* ヘッダーの水色 */
      --gray:#6b7280;   /* ラベル等のグレー */
      --chip:#6f7a87;   /* チップ背景 */
      --text:#374151;
      --bg:#f8fafc;
      --card:#ffffff;
      --shadow:0 10px 25px rgba(0,0,0,.06);
      --radius:14px;
    }
    *{box-sizing:border-box}
    body{margin:0;background:var(--bg);font-family:-apple-system,BlinkMacSystemFont,"Hiragino Sans","Segoe UI",Arial,sans-serif;color:var(--text)}
    .wrap{max-width:1000px;margin:40px auto;padding:0 16px}
    .header{background:var(--cyan);border-radius:16px;box-shadow:var(--shadow);padding:16px 18px;display:flex;align-items:center;gap:12px;position:relative}
    .chip{background:var(--chip);color:#fff;padding:10px 16px;border-radius:999px;font-weight:700;letter-spacing:.08em;box-shadow:inset 0 -2px 0 rgba(255,255,255,.2)}
    .spacer{flex:1}
    .logout{color:#fff;font-weight:800;letter-spacing:.1em}
    .logout form{display:inline}
    .logout button{all:unset;cursor:pointer;padding:8px 12px;border-radius:8px}
    .logout button:hover{background:rgba(255,255,255,.18)}
    .card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);padding:26px;margin-top:28px}
    .title{font-size:14px;color:#94a3b8;margin-bottom:14px}
    .info-row{display:flex;gap:16px;margin:8px 0;align-items:center}
    .label{width:120px;color:var(--gray)}
    .value{font-weight:600}
  </style>
</head>
<body>
  <div class="wrap">
    <!-- ヘッダー（左に3つのボタン、右にログアウト） -->
    <div class="header">
      <a class="chip" href="{{ route('admin.classes.index') }}">授業管理</a>
      <a class="chip" href="{{ route('admin.news.index') }}">お知らせ管理</a>
      <a class="chip" href="{{ route('admin.banners.index') }}">バナー管理</a>
      <div class="spacer"></div>
      <div class="logout">
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit">ログアウト</button>
        </form>
      </div>
    </div>

    <!-- 本文（ユーザー情報カード） -->
    <div class="card">
      <div class="title">プロフィール</div>
      <div class="info-row">
        <div class="label">ユーザーネーム</div>
        <div class="value">{{ $name }}</div>
      </div>
      <div class="info-row">
        <div class="label">メールアドレス</div>
        <div class="value">{{ $email }}</div>
      </div>
    </div>
  </div>
</body>
</html>
