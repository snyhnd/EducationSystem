<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>時間割</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    :root{
      --coral:#f0735c; --cyan:#39c8d5; --cyan-dark:#27b4c2; --chip:#1f2937;
      --bg:#f7fafc; --text:#374151; --muted:#6b7280; --card:#fff;
      --shadow:0 10px 24px rgba(0,0,0,.08); --radius:14px;
      --pill:#e6f7fb; --pill-active:#8cc63f;
    }
    *{box-sizing:border-box}
    body{margin:0;background:var(--bg);font-family:-apple-system,BlinkMacSystemFont,"Hiragino Sans","Segoe UI",Arial,sans-serif;color:var(--text)}
    a{color:inherit;text-decoration:none}
    .wrap{max-width:1180px;margin:28px auto;padding:0 16px}

    .topbar{background:var(--coral);border-radius:16px;padding:16px 18px;color:#fff;display:flex;align-items:center;gap:12px;box-shadow:var(--shadow)}
    .menu-btn{background:var(--cyan);color:#fff;border-radius:999px;padding:12px 18px;font-weight:800;letter-spacing:.1em;box-shadow:inset 0 -2px 0 rgba(255,255,255,.25)}
    .menu-btn:hover{background:var(--cyan-dark)}
    .chip{background:#3b4451;border-radius:999px;color:#fff;padding:10px 14px;font-weight:700}
    .spacer{flex:1}
    .logout form{display:inline}
    .logout button{all:unset;cursor:pointer;color:#fff;font-weight:800;letter-spacing:.1em;padding:8px 12px;border-radius:8px}
    .logout button:hover{background:rgba(255,255,255,.2)}

    .toolbar{display:flex;align-items:center;gap:12px;margin:14px 0 6px;flex-wrap:wrap}
    .back{margin:8px 0;display:inline-block}
    .month-title{font-size:22px;font-weight:800}
    .nav-arrow{font-size:22px;font-weight:900;padding:0 6px}

    .grade-pill{background:var(--pill);border-radius:999px;padding:6px 12px;color:#1493a1;font-weight:700;border:1px solid #b9ebf5;white-space:nowrap}
    .grade-pill.active{background:var(--pill-active);color:#fff;border-color:transparent}

    .content{display:grid;grid-template-columns:220px 1fr;gap:24px;margin-top:10px}
    .grade-list{display:flex;flex-direction:column;gap:12px;padding-top:6px}
    .grade-list a{display:block;text-align:center;padding:10px 12px;border-radius:999px;background:var(--pill);color:#1493a1;border:1px solid #b9ebf5;font-weight:700}
    .grade-list a.active{background:var(--pill-active);color:#fff;border:none}

    /* カレンダー */
    .cal{width:100%;border-collapse:separate;border-spacing:8px}
    .cal th{font-weight:800;text-align:center;color:#6b7280}
    .cal td{vertical-align:top;background:var(--card);border-radius:12px;box-shadow:var(--shadow);padding:10px;min-height:110px}
    .cal .day{font-weight:800;margin-bottom:6px}
    .badge{display:inline-block;font-size:12px;padding:3px 8px;border-radius:999px;background:var(--pill);color:#1493a1;border:1px solid #b9ebf5;margin:2px 0}
    .text-sm{font-size:13px;line-height:1.4}
    .muted{color:var(--muted)}

    @media (max-width:992px){.content{grid-template-columns:1fr}}
  </style>
</head>
<body>
<div class="wrap">

  <!-- 上部ヘッダー -->
  <div class="topbar">
    <a class="menu-btn" href="{{ route('user.schedule') }}">時間割</a>
    <a class="menu-btn" href="#">授業進捗</a>
    <a class="chip"     href="#">プロフィール設定</a>
    <div class="spacer"></div>
    <div class="logout">
      <form method="POST" action="{{ route('user.logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
      </form>
    </div>
  </div>

  <!-- 戻る＋月移動＋学年表示 -->
  <a class="back" href="javascript:history.back()">&larr; 戻る</a>

  @php
    // Controller から渡ってくる $current（Carbon） をベースに prev/next を算出
    $prev = $current->copy()->subMonth();
    $next = $current->copy()->addMonth();
  @endphp

  <div class="toolbar">
    <a class="nav-arrow" href="{{ route('user.schedule', ['year'=>$prev->year, 'month'=>$prev->month, 'grade'=>$selectedGrade]) }}">◀</a>
    <div class="month-title">{{ $current->format('Y年n月') }} スケジュール</div>
    <a class="nav-arrow" href="{{ route('user.schedule', ['year'=>$next->year, 'month'=>$next->month, 'grade'=>$selectedGrade]) }}">▶</a>
    <span class="grade-pill active">{{ $selectedGrade }}</span>
  </div>

  <div class="content">
    <!-- 左カラム：学年一覧 -->
    <nav class="grade-list">
      @foreach ($grades as $g)
        <a class="{{ (string)$g === (string)$selectedGrade ? 'active' : '' }}"
           href="{{ route('user.schedule', ['year'=>$current->year, 'month'=>$current->month, 'grade'=>$g]) }}">
          {{ $g }}
        </a>
      @endforeach
    </nav>

    <!-- 右カラム：カレンダー（週×日マトリクス） -->
    <section>
      <table class="cal">
        <thead>
          <tr>
            @foreach (['日','月','火','水','木','金','土'] as $w)
              <th>{{ $w }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($matrix as $week)
            <tr>
              @foreach ($week as $cell)
                <td>
                  <div class="day">{{ $cell['date']->format('j') }}</div>

                  @forelse ($cell['items'] as $item)
                    <div class="text-sm">
                      {{-- 授業タイトル --}}
                      <div class="badge">
                        {{ optional($item->curriculum)->title ?? '未設定' }}
                      </div>
                      {{-- コマ番号 or 開始終了時刻など、あれば表示 --}}
                      @if(!empty($item->period))
                        <div class="muted">（{{ $item->period }}限）</div>
                      @endif
                      @if(!empty($item->start_time) && !empty($item->end_time))
                        <div class="muted">
                          {{ \Illuminate\Support\Str::of($item->start_time)->substr(0,5) }}–{{ \Illuminate\Support\Str::of($item->end_time)->substr(0,5) }}
                        </div>
                      @endif
                    </div>
                  @empty
                    <div class="muted">予定なし</div>
                  @endforelse
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
</div>
</body>
</html>
