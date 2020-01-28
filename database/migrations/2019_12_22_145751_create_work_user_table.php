<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_work', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('work_id');
            
            $table->unsignedBigInteger('user_id'); // 案件に応募したユーザid
            $table->foreign('work_id')->references('id')->on('works');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_work', function (Blueprint $table) {
            $table->dropForeign(['user_id'],['work_id']);
        });
        Schema::dropIfExists('user_work');
    }
}
