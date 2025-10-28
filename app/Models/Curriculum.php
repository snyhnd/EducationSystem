<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    // 明示的にテーブル名を指定（必要なら）
    protected $table = 'curriculums'; // 実際のテーブル名に合わせて変更

    // 代入可能なカラム（セキュリティ対策）
    protected $fillable = [
        'title',
        'grade_id',
        'date',
        'time',
        'image_url',
        'thumbnail',
        'description',
        'video_url',
        'alway_delivery_flg'
    ];

    // 日付型として扱うカラム（Carbonで操作しやすくなる）
    protected $dates = ['date'];

    /**
     * スコープ：年・月・学年で絞り込み
     */
    public function scopeForSchedule($query, $year, $month, $gradeId)
    {
        return $query
            ->where('grade_id', $gradeId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month);
    }

    /**
     * リレーション：学年
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * 指定されたカリキュラムID群に対応する学年ID一覧を取得（重複なし・昇順）
     *
     * @param \Illuminate\Support\Collection|array $curriculumIds
     * @return \Illuminate\Support\Collection
     */
    public static function getClearedGradeIdsByCurriculumIds($curriculumIds)
    {
        return self::whereIn('id', $curriculumIds)
            ->pluck('grade_id')
            ->unique()
            ->sort();
    }
}
