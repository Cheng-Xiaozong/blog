<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAriticleCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ariticle_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->integer('project_id')->comment('文章ID');
            $table->integer('floor_id')->comment('层ID');
            $table->integer('parent_user_id')->comment('父ID');
            $table->string('content')->comment('内容');
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
        Schema::drop('ariticle_comments');
    }
}
