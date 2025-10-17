<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>時間割画面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9f9f9; font-family: "Hiragino Kaku Gothic ProN", sans-serif; }
        .navbar-custom { background-color: #f16c4f; color: #fff; padding: 12px 20px; }
        .navbar-custom .btn { font-weight: bold; border: none; border-radius: 20px; margin-right: 8px; }
        .btn-timetable { background-color: #00a0a0; color: white; }
        .btn-progress { background-color: #58b2dc; color: white; }
        .btn-profile { background-color: #48c9b0; color: white; }
        .btn-logout { background-color: #f16c4f; color: white; float: right; }
        .year-grade-btn { display: block; width: 120px; margin: 10px auto; border-radius: 20px; background-color: #bce2e8; border: none; padding: 8px 0; font-weight: bold; }
        .year-grade-btn.active { background-color: #99cc99; color: white; }
        .schedule-title { text-align: center; font-size: 1.4rem; font-weight: bold; margin: 20px 0; }
        .card img { width: 100%; border-radius: 8px 8px 0 0; }
        .card { border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .card-body { text-align: center; }
        .no-data { text-align: center; color: #666; margin-top: 50px; font-size: 1.1rem; }
    </style>
</head>
<body>

{{-- ヘッダー --}}
<div class="navbar-custom d-flex justify-content-between align-items-center">
    <div>
        <button class="btn btn-timetable">時間割</button>
        <button class="btn btn-progress">授業進捗</button>
        <button class="btn btn-profile">プロフィール設定</button>
    </div>
    <button class="btn btn-logout">ログアウト</button>
</div>

<div class="container-fluid mt-4">
    <div class="row">
        {{-- 左サイド（学年ボタン） --}}
        <div class="col-md-2 text-center">
            @foreach ($grades as $grade)
                <a href="{{ route('timetable', ['year' => $date->year, 'month' => $date->month, 'grade' => $grade]) }}"
                   class="btn year-grade-btn {{ $selectedGrade == $grade ? 'active' : '' }}">
                    {{ $grade }}
                </a>
            @endforeach
        </div>

        {{-- 右側メインスケジュール --}}
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('timetable', ['year' => $date->copy()->subMonth()->year, 'month' => $date->copy()->subMonth()->month, 'grade' => $selectedGrade]) }}"
                   class="btn btn-outline-secondary">◀ 前月</a>

                <div class="schedule-title">{{ $date->format('Y年n月') }}（{{ $selectedGrade }}）スケジュール</div>

                <a href="{{ route('timetable', ['year' => $date->copy()->addMonth()->year, 'month' => $date->copy()->addMonth()->month, 'grade' => $selectedGrade]) }}"
                   class="btn btn-outline-secondary">次月 ▶</a>
            </div>

            <div class="row mt-3">
                @forelse ($curriculums as $curriculum)
                    @foreach ($curriculum->deliveryTimes as $time)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ $curriculum->thumbnail ? asset('storage/'.$curriculum->thumbnail) : 'https://via.placeholder.com/300x180?text=No+Image' }}" alt="授業画像">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $curriculum->title }}</h5>
                                    <p class="card-text">
                                        {{ \Carbon\Carbon::parse($time->delivery_date)->format('n月j日') }}<br>
                                        {{ \Carbon\Carbon::parse($time->start_time)->format('H:i') }}〜{{ \Carbon\Carbon::parse($time->end_time)->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div class="no-data">
                        {{ $selectedGrade }} の {{ $date->format('n月') }} の授業スケジュールは登録されていません。
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

</body>
</html>
