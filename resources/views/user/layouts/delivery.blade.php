@extends('user.layouts.app') 

@section('content')
    <div class="container py-4">

        {{-- ヘッダー：橙色背景＋ナビゲーション --}}
        <header style="background-color: #fd7e14; color: white;" class="py-3 px-4 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('schedule') }}" class="btn btn-success me-2">時間割</a>
                    <a href="#" class="btn btn-success me-2">授業進捗</a>
                    <a href="#" class="btn btn-success">プロフィール設定</a>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-white text-decoration-underline">ログアウト</button>
                </form>
            </div>
        </header>

        {{-- 戻るリンク --}}
        <div class="mb-3">
            <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">&larr; 戻る</a>
        </div>

        {{-- 授業動画 --}}
        <div class="mb-4">
            <div class="row">
                {{-- 左側：動画 --}}
                <div class="col-md-8">
                    <iframe width="480" height="270" src="https://www.youtube.com/embed/動画ID" title="授業動画" allowfullscreen></iframe>
                </div>

                {{-- 右側：受講ボタン --}}
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <form method="POST" action="{{ route('curriculum.clear', ['id' => $curriculum->id]) }}">
                        @csrf
                        <input type="hidden" name="grade_id" value="{{ old('grade_id', $grade_id ?? '') }}">


                        <button type="submit" class="btn btn-warning btn-lg px-4 py-2">
                            受講しました
                        </button>
                    </form>
                   


                </div>
            </div>

            {{-- 学年ラベルを動画の下に表示 --}}
            <h4 class="mt-3 px-3 py-2 text-white bg-success d-inline-block rounded">
                {{ $grade }}
            </h4>
        
            <!-- <h4 class="mt-3">{{ $grade }}</h4> -->
        </div>

        {{-- ページ下部：授業タイトルと講座内容 --}}
       <div class="mt-5 pt-3 border-top">
    <h5 class="mb-3">{{ $curriculum->title ?? 'タイトル未設定' }}</h5>
    <h6 class="text-muted">講座内容</h6>
    <p>
        {{ $curriculum->description ?? '説明がまだ登録されていません。' }}
    </p>
</div>


</div>

    </div>
@endsection
