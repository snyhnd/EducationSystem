<!-- MARK: register.blade.php loaded -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <title>新規管理ユーザー登録</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body { background:#f8f9fa; margin:0; font-family:-apple-system,BlinkMacSystemFont,"Hiragino Sans","Segoe UI",Arial,sans-serif; }
    .page { max-width:760px; margin:40px auto; padding:0 16px; }
    .top { text-align:right; margin-bottom:8px; }
    .top a { color:#666; text-decoration:none; }
    .top a:hover { text-decoration:underline; }
    h1 { text-align:center; color:#666; margin:18px 0 22px; }
    .card { background:#fff; padding:24px; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,.06); }
    .row { display:grid; grid-template-columns:160px 1fr; gap:12px 14px; }
    label { align-self:center; color:#666; font-weight:600; }
    input { height:42px; border:1px solid #ddd; border-radius:8px; padding:8px 10px; width:100%; }
    .help { grid-column:2 / -1; color:#999; font-size:12px; margin-top:-6px; }
    .actions { text-align:center; margin-top:18px; }
    button { width:280px; height:52px; background:#666; color:#fff; border:none; border-radius:10px; font-weight:800; font-size:18px; letter-spacing:.1em; }
  </style>
</head>
<body>
  <!-- MARK: register.blade.php loaded -->
  <div class="page">
    <!-- ← ここに“必ず見える”ログインリンクを置く -->
    <div class="top"><a href="/admin/login">ログインはこちら</a></div>

    <h1>新規管理ユーザー登録</h1>

    @if(session('success'))
      <div style="background:#e9f7ef;border:1px solid #b7e1c3;padding:8px 12px;border-radius:8px;margin-bottom:12px;">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div style="background:#fdecea;border:1px solid #f5c2c7;padding:8px 12px;border-radius:8px;margin-bottom:12px;">
        <ul style="margin:0;padding-left:18px;">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card">
      <form method="POST" action="{{ route('admin.register.store') }}">
        @csrf
        <div class="row">
          <label>ユーザーネーム</label>
          <input type="text" name="username" value="{{ old('username') }}" required>

          <label>カナ</label>
          <input type="text" name="kana" value="{{ old('kana') }}" required>

          <label>メールアドレス</label>
          <input type="email" name="email" value="{{ old('email') }}" required>

          <label>パスワード</label>
          <input type="password" name="password" required>
          <div class="help">最小 8 文字</div>

          <label>パスワード確認</label>
          <input type="password" name="password_confirmation" required>
        </div>

        <div class="actions">
          <button type="submit">登録</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

