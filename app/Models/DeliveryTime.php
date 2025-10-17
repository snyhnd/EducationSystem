<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    use HasFactory;

    protected $table = 'delivery_times';

    protected $fillable = [
        'curriculum_id',
        'delivery_date',
        'start_time',
        'end_time',
        'always_delivery_flg',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
