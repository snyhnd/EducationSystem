<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesTableSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            '小学校1年生','小学校2年生','小学校3年生','小学校4年生','小学校5年生','小学校6年生',
            '中学校1年生','中学校2年生','中学校3年生',
            '高校1年生','高校2年生','高校3年生',
        ];
        foreach ($names as $name) {
            DB::table('classes')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}