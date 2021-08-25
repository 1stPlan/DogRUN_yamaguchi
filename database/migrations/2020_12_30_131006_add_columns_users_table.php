<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('email_verified')->after('email_verified_at')->default(0);
            $table->string('email_verify_token')->after('email_verified')->nullable();
            $table->integer('login_count')->default(0);
            // $table->string('img_url')->nullable();
            $table->string('img_no')->nullable();
            $table->string('intro')->nullable();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified');
            $table->dropColumn('email_verify_token');
            $table->dropColumn('login_count');
            $table->dropColumn('img_no');
            // $table->dropColumn('img_url');
            $table->dropColumn('intro');
            $table->dropColumn('deleted_at');
        });
    }
};
