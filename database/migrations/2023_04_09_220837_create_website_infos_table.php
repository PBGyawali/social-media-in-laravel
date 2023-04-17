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
        Schema::create('website_infos', function (Blueprint $table) {
            $table->bigIncrements('website_id');
            $table->string('website_name')->nullable();
            $table->string('website_address')->nullable();
            $table->string('website_email')->nullable();
            $table->string('website_contact_no')->nullable();
            $table->string('website_timezone')->nullable();
            $table->string('website_currency')->nullable();
            $table->string('website_tagline')->nullable();
            $table->string('website_theme')->nullable();
            $table->string('website_logo')->nullable();
            $table->string('owner_email')->nullable();
            $table->string('secret_password')->nullable();
            $table->integer('owner_postal_code')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_address')->nullable();
            $table->string('owner_contact_no')->nullable();
            $table->string('owner_country')->nullable();
            $table->string('user_target')->nullable();
            $table->string('owner_photo')->nullable();
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
        Schema::dropIfExists('website_infos');
    }
};
