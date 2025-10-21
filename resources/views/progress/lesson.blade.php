@extends('layouts.app')

@section('content')
<div style="width: 80%; margin: 50px auto;">
    <a href="{{ route('progress.index') }}" style="text-decoration:none; color:#333;">← 戻る</a>
    <h2>{{ $grade }} の {{ $lesson }}</h2>
    <p>ここに {{ $lesson }} の授業内容を表示する予定です。</p>
</div>
@endsection