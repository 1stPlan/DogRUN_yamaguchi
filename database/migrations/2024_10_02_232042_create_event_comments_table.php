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
    public function up()
    {
        Schema::create('event_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_post_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('body');
            $table->timestamps();
            $table
                ->foreign('event_post_id')
                ->references('id')
                ->on('event_posts')
                ->onDelete('cascade');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_comments');
    }
};
