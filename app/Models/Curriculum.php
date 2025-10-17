<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $table = 'curriculums'; // テーブル名が違う場合は変更
    protected $fillable = ['title','thumbnail','video_url','grade']; // grade無ければ外してOK

    public function deliveryTimes()
    {
        return $this->hasMany(DeliveryTime::class);
    }
}
