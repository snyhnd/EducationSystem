<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CurriculumProgressSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('curriculum_progress')->insert([
            [
                'curriculums_id' => 1,
                'users_id' => 1,
                'grade_id' => 1,
                'clear_flg' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'curriculums_id' => 2,
                'users_id' => 1,
                'grade_id' => 1,
                'clear_flg' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}

