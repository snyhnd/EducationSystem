<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'grade', 'thumbnail', 'video_url',
        // 必要に応じて他のカラムを追加
    ];

    /** 関連 */
    public function deliveryTimes()
    {
        return $this->hasMany(DeliveryTime::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /** 公開中などのスコープ（必要なら） */
    public function scopeForGrade($query, ?int $grade)
    {
        return $grade ? $query->where('grade', $grade) : $query;
    }

    /**
     * 指定ユーザーの「月間スケジュール + カリキュラム」を取得
     * Controller からはこの窓口だけ呼ぶ。
     */
    public static function fetchForMonth(?int $userId, Carbon $month)
    {
        $start = (clone $month)->startOfMonth();
        $end   = (clone $month)->endOfMonth();

        // schedules テーブル（user_id, date, curriculum_id 等を想定）
        return Schedule::with(['curriculum', 'curriculum.deliveryTimes'])
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('date')
            ->get();
    }

    /**
     * 画面用：カレンダー形に整形（週×日）した配列を返す
     * Blade 側がマトリクスを期待する場合に使用。
     */
    public static function buildMonthMatrix(?int $userId, Carbon $month): array
    {
        $schedules = self::fetchForMonth($userId, $month);
        $first = (clone $month)->startOfMonth()->startOfWeek();   // 週頭から
        $last  = (clone $month)->endOfMonth()->endOfWeek();       // 週末まで

        $cursor = $first->copy();
        $matrix = [];
        while ($cursor->lte($last)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $day = $cursor->copy();
                $items = $schedules->where('date', $day->toDateString())->values();
                $week[] = ['date' => $day, 'items' => $items];
                $cursor->addDay();
            }
            $matrix[] = $week;
        }
        return $matrix;
    }
}
