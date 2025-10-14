<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArticlesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('articles')->insert([
            [
                'title' => 'お知らせタイトル',
                'posted_date' => '2023-07-21',
                'article_contents' => 'お知らせの本文がここに入ります。テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '夏季休業のお知らせ',
                'posted_date' => '2023-08-10',
                'article_contents' => '夏季休業期間のお知らせです。期間中はお問い合わせ対応をお休みさせていただきます。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '新機能リリースのお知らせ',
                'posted_date' => '2023-09-05',
                'article_contents' => '新しい授業管理機能を追加しました。詳細はマイページよりご確認ください。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}