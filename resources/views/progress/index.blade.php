@extends('layouts.app')

@section('content')
<style>
    .sub-header {
        background-color: #EF6C43;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 40px;
        border-radius: 10px;
        width: 80%;
        margin: 30px auto 0;
    }

    .nav-left { display: flex; gap: 15px; }
    .nav-left a {
        background-color: #12b0b0;
        color: #fff;
        padding: 10px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }
    .nav-left a.active { background-color: #0c8a8a; }

    .logout { color: #fff; text-decoration: none; font-weight: bold; font-size: 18px; }
    .logout:hover { text-decoration: underline; }

    .progress-container {
        width: 80%;
        margin: 40px auto;
        text-align: left;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
    }
    .back-link:hover { text-decoration: underline; }

    .student-info {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 40px;
    }

    .student-info img {
        width: 120px;
        height: 120px;
        border-radius: 10px;
        object-fit: cover;
        background-color: #f2f2f2;
    }

    .student-text {
        font-size: 20px;
        color: #222;
    }

    .grade-badge {
        color: #fff;
        padding: 5px 12px;
        border-radius: 15px;
        font-weight: bold;
        margin-left: 10px;
    }

    .badge-elementary { background-color: #8BE6E6; }
    .badge-junior { background-color: #66CDAA; }
    .badge-high { background-color: #A5D86E; }

    .grade-label {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 15px;
        color: white;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .elementary { background-color: #8BE6E6; }
    .junior { background-color: #66CDAA; }
    .high { background-color: #A5D86E; }

    .grades-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
        margin-top: 30px;
    }

    .curriculum-list {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .curriculum-row {
        display: grid;
        grid-template-columns: 80px 1fr;
        align-items: center;
    }

    .curriculum-title a {
        color: #007bff;
        text-decoration: none;
    }

    .curriculum-title a:hover {
        text-decoration: underline;
    }

    .cleared-label {
        color: red;
        font-weight: bold;
    }
</style>

{{-- ===== オレンジヘッダー ===== --}}
<div class="sub-header">
    <div class="nav-left">
        <a href="{{ route('schedule.index') }}">時間割</a>
        <a href="{{ route('progress.index') }}" class="active">授業進捗</a>
        <a href="{{ route('profile.edit') }}">プロフィール設定</a>
    </div>

    <a href="{{ route('logout') }}" class="logout"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ログアウト
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>

{{-- ===== メインコンテンツ ===== --}}
<div class="progress-container">
    <a href="{{ route('top') }}" class="back-link">← 戻る</a>

    @php
        $gradeName = $user->grade->name ?? '未設定';
        $gradeClass = str_contains($gradeName, '小') ? 'badge-elementary' :
                      (str_contains($gradeName, '中') ? 'badge-junior' : 'badge-high');
    @endphp

    <div class="student-info">
        {{--プロフィール画像をDBから反映 --}}
        <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('images/sample-avatar.png') }}" alt="プロフィール画像">
        <div class="student-text">
            <h2>{{ $user->name }}さんの授業進捗</h2>
            <p>現在の学年：
                <span class="grade-badge {{ $gradeClass }}">{{ $gradeName }}</span>
            </p>
        </div>
    </div>

    {{-- ===== 授業リスト（学年ごと） ===== --}}
    <div class="grades-grid">
        @foreach (config('grades.list') as $grade)
            @php
                $colorClass = str_contains($grade, '小') ? 'elementary' :
                              (str_contains($grade, '中') ? 'junior' : 'high');
            @endphp

            <div class="grade-section">
                <h3><span class="grade-label {{ $colorClass }}">{{ $grade }}</span></h3>
                <div class="curriculum-list">
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="curriculum-row">
                            <span class="cleared-label">
                                {{ $grade === $gradeName && ($i === 1 || $i === 2) ? '受講済み' : '' }}
                            </span>

                            <span class="curriculum-title">
                                {{-- ログイン中ユーザーの学年だけリンク表示 --}}
                                @if ($grade === $gradeName)
                                    <a href="{{ route('progress.show', ['grade' => $grade, 'lesson' => '授業タイトル'.$i]) }}">
                                        授業タイトル{{ $i }}
                                    </a>
                                @else
                                    授業タイトル{{ $i }}
                                @endif
                            </span>
                        </div>
                    @endfor
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection