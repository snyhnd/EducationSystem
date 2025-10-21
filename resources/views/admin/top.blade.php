@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">管理者トップ画面</h1>
    <p>ここから授業・お知らせ・バナーなどの管理が行えます。</p>

    <div class="mt-4">
        <a href="{{ route('admin.articles.index') }}" class="btn btn-info">お知らせ管理</a>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-success">バナー管理</a>
    </div>
</div>
@endsection