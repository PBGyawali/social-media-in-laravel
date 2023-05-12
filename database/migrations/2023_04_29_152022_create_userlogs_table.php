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
        Schema::create('userlogs', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('user_status')->default('inactive');
            $table->string('verified')->default('inactive');
            $table->string('email_status')->default('inactive');
            $table->timestamp('last_login_attempt')->nullable()->useCurrent();
            $table->timestamp('Last_Logout')->nullable()->useCurrent();
            $table->timestamp('last_password_change')->nullable()->useCurrent();
            $table->timestamp('LastActive')->useCurrent();
            $table->string('login')->nullable()->default('dashboard');
            $table->string('remarks')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userlogs');
    }
};
