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

    // スコープ：年・月・学年で絞り込み
   public function scopeForSchedule($query, $year, $month, $gradeId)
{
    return $query->where('grade_id', $gradeId)
                 ->whereYear('date', $year)
                 ->whereMonth('date', $month);
}

public function grade()
{
    return $this->belongsTo(Grade::class);
}

}