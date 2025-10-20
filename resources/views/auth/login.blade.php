<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザーログイン</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="mx-auto bg-white p-4 rounded-3 shadow" style="max-width:420px">
      <h2 class="mb-4 text-center">ログイン</h2>

      <form>
        <div class="mb-3">
          <label class="form-label">メールアドレス</label>
          <input type="email" class="form-control" placeholder="example@mail.com">
        </div>
        <div class="mb-4">
          <label class="form-label">パスワード</label>
          <input type="password" class="form-control" placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn-primary w-100">ログイン</button>
      </form>
    </div>
  </div>
</body>
</html>
