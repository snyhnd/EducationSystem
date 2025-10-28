<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // migrationファイル内
public function up()
{
    Schema::table('classroom_students', function (Blueprint $table) {
        $table->integer('year')->nullable(); // 必要に応じて型と制約を調整
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classroom_students', function (Blueprint $table) {
            //
        });
    }
};
