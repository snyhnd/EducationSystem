<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();

            // 基本情報
            $table->string('title');                 // タイトル
            $table->string('video_url')->nullable(); // 動画URL（外部/内部どちらでも想定）
            $table->string('thumbnail')->nullable(); // サムネ画像パス

            // 配信期間
            $table->dateTime('delivery_from')->nullable(); // 配信開始
            $table->dateTime('delivery_to')->nullable();   // 配信終了
            $table->boolean('always_delivery_flg')
                  ->default(false);                        // 期間関係なく常時配信

            $table->timestamps(); // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculums');
    }
};
