<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('curriculum', function (Blueprint $table) {
            $table->id();
            $table->string('title');         // 授業タイトル
            $table->string('grade');         // 学年（例：小学校1年生）
            $table->date('date');            // 実施日
            $table->string('time');          // 実施時間（例：14:00～15:00）
            $table->string('image_url')->nullable(); // 授業画像（任意）
            $table->timestamps();            // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum');
    }
};

