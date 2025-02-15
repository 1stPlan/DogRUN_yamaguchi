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
        Schema::create('places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            // $table->string('data_id');
            $table->string('address');
            $table->string('tag');
            $table->string('price');
            $table->string('time');
            $table->string('off');
            $table->string('tel')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('url');
            $table->string('service_1')->nullable();
            $table->string('service_2')->nullable();
            $table->string('service_3')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('places');
    }
};
