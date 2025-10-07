<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_times', function (Blueprint $table) {
            $table->id();

            // 紐付け：カリキュラムが消えたらスケジュールも消す
            $table->foreignId('curriculums_id')
                  ->constrained('curriculums')
                  ->onDelete('cascade');

            // 配信の開始・終了
            $table->dateTime('start_at');           // 配信開始日時
            $table->dateTime('end_at')->nullable(); // 配信終了日時（単発ならnullでもOK）

            // もし学年(grade)等で絞るならここで追加（シートの "geades/geads" を学年と解釈）
            // $table->unsignedTinyInteger('grade')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_times');
    }
};
