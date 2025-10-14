<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurriculumsTableSeeder extends Seeder
{
    public function run(): void
    {
        // 各学年に5件ずつダミーカリキュラムを投入
        $gradeCount = DB::table('classes')->count();
        for ($g = 1; $g <= $gradeCount; $g++) {
            for ($i = 1; $i <= 5; $i++) {
                DB::table('curriculums')->insert([
                    'title' => "授業タイトル{$i}",
                    'thumbnail' => null,
                    'description' => "学年{$g} 用のダミー説明 {$i}",
                    'video_url' => null,
                    'alway_delivery_flg' => ($i === 1), // 1つだけ常時公開に
                    'grade_id' => $g,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}