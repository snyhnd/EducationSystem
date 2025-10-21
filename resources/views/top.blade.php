@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1>ようこそ！教育システムへ</h1>
    <p>ここから時間割・授業進捗・お知らせなどにアクセスできます。</p>

    <div class="mt-4">
        <a href="{{ route('schedule.index') }}" class="btn btn-primary">時間割</a>
        <a href="{{ route('progress.index') }}" class="btn btn-success">授業進捗</a>
        <a href="{{ route('articles.index') }}" class="btn btn-info">お知らせ一覧</a>
    </div>
</div>
@endsection