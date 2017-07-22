<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('head_portrait')->comment('头像');
            $table->smallInteger('sex')->default(0)->comment('性别(0女1男)');
            $table->string('hobby')->comment('爱好');
            $table->string('signature')->comment('个性签名');
            $table->string('details')->comment('自我评价');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
