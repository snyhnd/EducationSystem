<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <title>管理画面ログイン</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body { background:#f8f9fa; margin:0; font-family:-apple-system,BlinkMacSystemFont,"Hiragino Sans","Segoe UI",Arial,sans-serif; color:#444; }
    .page { max-width:760px; margin:60px auto; padding:0 16px; position:relative; }
    .top-link { position:absolute; right:0; top:-26px; font-size:14px; color:#888; }
    .top-link a { color:#888; text-decoration:none; } .top-link a:hover{ text-decoration:underline; }
    h1 { text-align:center; font-size:32px; color:#666; margin:24px 0 28px; font-weight:700; letter-spacing:.06em; }
    .card { background:#fff; padding:28px 26px; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,.06); }
    .row { display:grid; grid-template-columns:160px 1fr; gap:14px 16px; }
    label { align-self:center; color:#666; font-weight:600; }
    input { height:42px; border:1px solid #ddd; border-radius:8px; padding:8px 10px; width:100%; }
    .actions { text-align:center; margin-top:20px; }
    button { width:260px; height:48px; background:#666; color:#fff; border:none; border-radius:10px; font-weight:800; font-size:18px; letter-spacing:.1em; }
    .alert { background:#fdecea; border:1px solid #f5c2c7; color:#a33; padding:10px 12px; border-radius:8px; margin-bottom:14px; }
  </style>
</head>
<body>
  <div class="page">
    <!-- 右上：新規登録へ -->
    <div class="top-link">新規会員登録はこちら → <a href="{{ route('admin.register.create') }}">登録</a></div>

    <h1>管理画面ログイン</h1>

    @if ($errors->any())
      <div class="alert">
        <ul style="margin:0; padding-left:18px;">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card">
      <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="row">
          <label>メールアドレス</label>
          <input type="email" name="email" value="{{ old('email') }}" required>

          <label>パスワード</label>
          <input type="password" name="password" required>
        </div>

        <div class="actions">
          <button type="submit">ログイン</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
