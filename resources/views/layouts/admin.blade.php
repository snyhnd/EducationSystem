<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '管理画面')</title>
    <style>
        body {
            font-family: "Hiragino Kaku Gothic ProN", Meiryo, sans-serif;
            background-color: #fff;
            margin: 0;
        }
        header {
            background-color: #4fd1c5;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-left a {
            background-color: #38b2ac;
            color: #fff;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 20px;
            margin-right: 10px;
            font-weight: bold;
        }
        .nav-left a.active {
            background-color: #555;
        }
        .logout {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            padding: 30px 60px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
        }
        th {
            text-align: left;
        }
    </style>
</head>
<body>

<header>
    <div class="nav-left">
        <a href="{{ route('admin.dashboard') }}">授業管理</a>
        <a href="{{ route('admin.articles.index') }}" class="active">お知らせ管理</a>
        <a href="{{ route('admin.banners.index') }}">バナー管理</a>
    </div>
    <a href="{{ route('logout') }}" class="logout">ログアウト</a>
</header>

<main>
    @yield('content')
</main>

</body>
</html>