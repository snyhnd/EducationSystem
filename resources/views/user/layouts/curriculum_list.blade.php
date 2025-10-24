<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>スケジュール</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .btn-grade-1 { background-color: #f8c8dc; color: #333; }
        .btn-grade-2 { background-color: #c8e6c9; color: #333; }
        .btn-grade-3 { background-color: #ffe0b2; color: #333; }
        .btn-grade-4 { background-color: #d1c4e9; color: #333; }
        .btn-grade-5 { background-color: #b3e5fc; color: #333; }
        .btn-grade-6 { background-color: #f0f4c3; color: #333; }
        .btn-grade-j1 { background-color: #ffccbc; color: #333; }
        .btn-grade-j2 { background-color: #cfd8dc; color: #333; }
        .btn-grade-j3 { background-color: #dcedc8; color: #333; }
        .btn-grade-h1 { background-color: #f3e5f5; color: #333; }
        .btn-grade-h2 { background-color: #e1bee7; color: #333; }
        .btn-grade-h3 { background-color: #fff9c4; color: #333; }
        .btn.active {
            border: 2px solid #333;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">

<header style="background-color: #fd7e14; color: white;" class="py-3 px-4">
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

<div class="container py-4" id="main-content">
    @php
        use Carbon\Carbon;
        $year = request()->get('year', 2025);
        $month = request()->get('month', 10);
        $grade = request()->get('grade', '小学校1年生');
        $current = Carbon::create($year, $month);
        $prev = $current->copy()->subMonth();
        $next = $current->copy()->addMonth();

        $gradeClasses = [
            '小学校1年生' => 'btn-grade-1',
            '小学校2年生' => 'btn-grade-2',
            '小学校3年生' => 'btn-grade-3',
            '小学校4年生' => 'btn-grade-4',
            '小学校5年生' => 'btn-grade-5',
            '小学校6年生' => 'btn-grade-6',
            '中学校1年生' => 'btn-grade-j1',
            '中学校2年生' => 'btn-grade-j2',
            '中学校3年生' => 'btn-grade-j3',
            '高校1年生' => 'btn-grade-h1',
            '高校2年生' => 'btn-grade-h2',
            '高校3年生' => 'btn-grade-h3',
        ];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('user_dashboard') }}" class="btn btn-outline-secondary">&larr; 戻る</a>
        <h2 class="mb-0">
            <span id="schedule-title">{{ $current->year }}年{{ $current->month }}月スケジュール</span>
            <span class="ms-3 badge bg-info text-dark" id="selected-grade">{{ $grade }}</span>
        </h2>
        <div>
            <button class="btn btn-outline-secondary me-2 month-btn" data-year="{{ $prev->year }}" data-month="{{ $prev->month }}">←</button>
            <button class="btn btn-outline-secondary month-btn" data-year="{{ $next->year }}" data-month="{{ $next->month }}">→</button>
        </div>
    </div>

    <div class="row">
        {{-- 左側：学年一覧 --}}
        <div class="col-md-2">
            <div class="d-flex flex-column gap-2">

                @foreach ($grades as $gradeItem)
                    @php
                        $g = $gradeItem->name;
                        $gradeClass = $gradeClasses[$g] ?? 'btn-secondary';
                    @endphp
                    <button
                        class="btn {{ $gradeClass }} grade-btn {{ $grade === $g ? 'active' : '' }}"
                        data-grade="{{ $g }}"
                        data-grade-id="{{ $gradeItem->id }}"
                        @if ($gradeItem->id > $maxGradeId) disabled @endif
                    >
                        {{ $g }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- 右側：授業カード --}}
        <div class="col-md-10" id="schedule-area">
            <div class="row">
                <p class="text-muted">授業件数：{{ $lessons->count() }}件</p>

                @foreach ($lessons->take(6) as $lesson)
<div class="col-md-4 mb-4">
    <div class="card h-100">
        <img src="{{ $lesson->image_url }}" class="card-img-top" alt="Class Image">
        <div class="card-body">
            <h5 class="card-title">
                <button class="btn btn-link text-dark lesson-link"
                        data-id="{{ $lesson->id }}"

                        data-grade="{{ $grade }}">
                    {{ $lesson->title }}
                </button>
            </h5>
            <p class="card-text mb-1">
                {{ \Carbon\Carbon::parse($lesson->created_at)->format('n月j日') }}　{{ $lesson->time }}
            </p>
        </div>
    </div>
</div>
@endforeach

                <!-- @foreach ($lessons->take(6) as $lesson)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <img src="{{ $lesson->image_url }}" class="card-img-top" alt="Class Image">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ route('lesson.delivery', ['id' => $lesson->id, 'grade' => $grade]) }}" class="text-decoration-none text-dark">
                        {{ $lesson->title }}
                    </a>
                </h5>
                <p class="card-text mb-1">
                    {{ \Carbon\Carbon::parse($lesson->created_at)->format('n月j日') }}　{{ $lesson->time }}
                </p>
            </div>
        </div>
    </div>
@endforeach -->

            </div>
        </div>
    </div>
</div>

{{-- 非同期処理 --}}
<script>
$(function() {
    function loadSchedule(year, month, grade) {
        const gradeId = $('.grade-btn[data-grade="' + grade + '"]').data('grade-id');
        $.get('/schedule/partial', { year, month, grade, grade_id: gradeId }, function(data) {
            const html = $(data.html);
            $('#main-content').html(html.find('#main-content').html());

            $('#schedule-title').text(`${year}年${month}月スケジュール`);
            $('#selected-grade').text(grade);

            const prev = new Date(year, month - 2);
            const next = new Date(year, month);
            $('.month-btn').eq(0).data('year', prev.getFullYear()).data('month', prev.getMonth() + 1);
            $('.month-btn').eq(1).data('year', next.getFullYear()).data('month', next.getMonth() + 1);

            // 再度イベントをバインド
            $('.grade-btn').off('click').on('click', function() {
                const grade = $(this).data('grade');
                const titleText = $('#schedule-title').text();
                const year = titleText.match(/(\d+)年/)[1];
                const month = titleText.match(/(\d+)月/)[1];
                loadSchedule(year, month, grade);
            });

            $('.month-btn').off('click').on('click', function() {
                const year = $(this).data('year');
                const month = $(this).data('month');
                const grade = $('#selected-grade').text();
                loadSchedule(year, month, grade);
            });
        });
    }

    $('.grade-btn').on('click', function() {
        const grade = $(this).data('grade');
        const titleText = $('#schedule-title').text();
        const year = titleText.match(/(\d+)年/)[1];
        const month = titleText.match(/(\d+)月/)[1];
        loadSchedule(year, month, grade);
    });

    $('.month-btn').on('click', function() {
        const year = $(this).data('year');
        const month = $(this).data('month');
        const grade = $('#selected-grade').text();
        loadSchedule(year, month, grade);
    });
    $(document).off('click', '.lesson-link').on('click', '.lesson-link', function() {
    const id = $(this).data('id');
    const grade = $('#selected-grade').text(); // ← ここで画面上の表示から取得
    window.location.href = `/lesson/delivery/${id}?grade=${encodeURIComponent(grade)}`;
});

});
</script>

</body>
</html>
