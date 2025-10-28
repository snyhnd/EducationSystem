<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curriculum;

class CurriculumSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['title' => '自然の観察', 'date' => '2025-10-18'],
            ['title' => '宇宙の不思議', 'date' => '2025-10-20'],
            ['title' => '昆虫の世界', 'date' => '2025-10-22'],
            ['title' => '水の性質', 'date' => '2025-10-25'],
            ['title' => '音のひみつ', 'date' => '2025-10-28'],
        ];

        foreach ($data as $item) {
            Curriculum::create([
                'title' => $item['title'],
                'grade' => '小学校1年生',
                'date' => $item['date'], // ← date → date_time に合わせる
                'time' => '10:00～11:00',     // ✅ 追加！
                'delivery' => 'Zoom',
                'image_url' => '/uploads/photos/default.jpg',
            ]);
        }
    }
}

