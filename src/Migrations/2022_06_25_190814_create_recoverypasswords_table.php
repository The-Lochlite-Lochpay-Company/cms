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
        Schema::create('recoverypasswords', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->string('title')->default('Email Verify')->nullable();
            $table->string('description')->default("Thanks for signing up!")->nullable();
            $table->string('emphasis')->default('Thanks for signing up!')->nullable();
            $table->text('instruction')->nullable();
            $table->string('logintext')->default('Already have an account?')->nullable();
            $table->string('buttontext')->default('Sign up')->nullable();
            $table->string('buttoncolor')->default('bg-blue-600')->nullable();
            $table->string('buttontextcolor')->default('text-white')->nullable();
            $table->string('logo')->default('/application/72x72.png')->nullable();
            $table->string('image')->default('https://source.unsplash.com/user/erondu/1600x900')->nullable();
            $table->json('form')->nullable();
            $table->boolean('imagevisible')->default(true)->nullable();
            $table->string('default')->default(false)->nullable();
            $table->string('status')->default('active')->nullable();
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
        Schema::dropIfExists('recoverypasswords');
    }
};
