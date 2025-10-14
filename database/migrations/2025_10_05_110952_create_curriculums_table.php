<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->string('title');                       // カリキュラムタイトル
            $table->string('thumbnail')->nullable();       // サムネイルURL/パス
            $table->text('description')->nullable();       // 説明
            $table->string('video_url')->nullable();       // 動画URL
            $table->boolean('alway_delivery_flg')->default(false); // 常時公開
            $table->foreignId('grade_id')->constrained('classes')->cascadeOnDelete(); // 学年
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('curriculums');
    }
};