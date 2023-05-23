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
        Schema::create('visitor_log', function (Blueprint $table) {
            $table->integer('log_id', true);
            $table->integer('post_id');
            $table->integer('owner_id')->nullable();
            $table->integer('chrome')->default(0);
            $table->integer('firefox')->default(0);
            $table->integer('opera')->default(0);
            $table->integer('explorer')->default(0);
            $table->integer('safari')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor_log');
    }
};
