<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('curriculum_progress', function (Blueprint $table) {
            $table->id();

            // 外部キー関連
            $table->unsignedBigInteger('curriculums_id'); // カリキュラムID
            $table->unsignedBigInteger('users_id');       // ユーザーID
            $table->unsignedBigInteger('grade_id');       // 学年ID

            // 授業進捗フラグ
            $table->boolean('clear_flg')->default(false);

            // タイムスタンプ
            $table->timestamps();

            // 外部キー制約
            $table->foreign('curriculums_id')
                ->references('id')
                ->on('curriculums')
                ->onDelete('cascade');

            $table->foreign('users_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('grade_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum_progress');
    }
};