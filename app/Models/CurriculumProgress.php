<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumProgress extends Model
{
    protected $table = 'curriculum_progress';

    protected $fillable = [
        'users_id',
        'curriculums_id',
        'clear_flg',
    ];

    /**
     * 指定ユーザーの進捗マップを取得
     * 
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public static function getProgressMapByUser($userId)
    {
        return self::where('users_id', $userId)
            ->pluck('clear_flg', 'curriculums_id');
    }
}