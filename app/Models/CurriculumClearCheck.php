<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumClearCheck extends Model
{
   protected $table = 'classes_clear_checks';

    protected $fillable = ['users_id','grade_id', 'clear_flg'];
}

