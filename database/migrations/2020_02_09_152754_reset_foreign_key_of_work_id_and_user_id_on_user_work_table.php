<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResetForeignKeyOfWorkIdAndUserIdOnUserWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_work', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['work_id']);

            $table->foreign('work_id')->references('id')->on('works')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
            $table->dropForeign(['user_id']);
            $table->dropForeign(['work_id']);

            $table->foreign('work_id')->references('id')->on('works');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
