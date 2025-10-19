<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    /** 🔹明示的にテーブル名を指定（ここが重要！） */
    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'grade',
        'thumbnail',
        'video_url',
    ];

    public function deliveryTimes()
    {
        return $this->hasMany(DeliveryTime::class);
    }
}
