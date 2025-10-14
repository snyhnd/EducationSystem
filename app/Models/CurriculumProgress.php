<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumProgress extends Model
{
    protected $table = 'curriculum_progress';
    protected $fillable = ['curriculumus_id','users_id','clear_flg'];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculumus_id');
    }
}