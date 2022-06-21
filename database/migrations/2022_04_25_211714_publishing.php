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
        Schema::create('publishing', function (Blueprint $table) {
            $table->id('publish_id');
            $table->string('post_id')->references('post_id')->on('posts');
            $table->timestampTz('timing', $precision = 0);
            $table->boolean('is_published')->default(false);
            $table->string('account_id')->references('account_id')->on('accounts');
            $table->string('user_id')->references('user_id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
