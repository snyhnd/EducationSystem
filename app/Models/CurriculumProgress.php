<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumProgress extends Model
{
    use HasFactory;
    
    public static function getClearedCurriculumIdsByUser($userId)
     {
         return self::where('users_id', $userId)
             ->where('clear_flg', 1)
             ->pluck('curriculums_id');
     }


}
