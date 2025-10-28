<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>教育システム トップ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .banner-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }
        .indicator-btn {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
            background-color: #ccc;
            border: none;
        }
        .indicator-btn.active {
            background-color: #ff7f50;
        }
    </style>
</head>
<body class="bg-light">

<header style="background-color: #ff7f50; color: white;" class="py-3 px-4">
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

<div class="container py-4">
    {{-- バナー画像 --}}
    <div class="mb-4 text-center">
        @if (is_countable($banners) && count($banners) > 0)
    <img id="banner-image" src="{{ asset($banners[0]->image_path) }}" alt="バナー画像" class="banner-img mb-3">
@else
    <div class="banner-img mb-3 bg-secondary text-white d-flex align-items-center justify-content-center">
        バナー画像がありません
    </div>
@endif

        <div id="banner-indicators">
            @foreach ($banners as $index => $banner)
                <button class="indicator-btn" data-index="{{ $index }}"></button>
            @endforeach
        </div>
    </div>

    {{-- お知らせ --}}
    <hr>
    <h4 class="mb-3">お知らせ</h4>
    <ul class="list-group">
        @foreach ($articles as $article)
            <li class="list-group-item">
                <a href="{{ route('articles.show', $article->id) }}" class="text-decoration-none text-dark">
                    {{ $article->posted_date->format('Y年n月j日') }}　{{ $article->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<script>
    const banners = @json($banners);
    let currentIndex = 0;
    const bannerImage = document.getElementById('banner-image');
    const indicatorButtons = document.querySelectorAll('.indicator-btn');

    function showBanner(index) {
        bannerImage.src = banners[index].image_path.startsWith('http')
            ? banners[index].image_path
            : "{{ asset('') }}" + banners[index].image_path;
        indicatorButtons.forEach(btn => btn.classList.remove('active'));
        indicatorButtons[index].classList.add('active');
        currentIndex = index;
    }

    // 自動切り替え
    setInterval(() => {
        currentIndex = (currentIndex + 1) % banners.length;
        showBanner(currentIndex);
    }, 5000);

    // クリック切り替え
    indicatorButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const index = parseInt(btn.dataset.index);
            showBanner(index);
        });
    });

    // 初期表示
    showBanner(0);
</script>

</body>
</html>
