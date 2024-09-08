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
            $table->string('title')->default('Forgot Password')->nullable();
            $table->string('description')->default("Forgot your password? No problem.")->nullable();
            $table->string('emphasis')->default('Forgot your password? No problem.')->nullable();
            $table->text('instruction')->nullable();
            $table->string('logintext')->default('Did you remember your password?')->nullable();
            $table->string('buttontext')->default('EMAIL PASSWORD RESET LINK')->nullable();
            $table->string('buttoncolor')->default('bg-blue-600')->nullable();
            $table->string('buttontextcolor')->default('text-white')->nullable();
            $table->string('logo')->default('/application/72x72.png')->nullable();
            $table->string('image')->default('https://images.wallpaperscraft.com/image/single/city_night_aerial_view_154153_1600x900.jpg')->nullable();
            $table->json('form')->nullable();
            $table->boolean('imagevisible')->default(true)->nullable();
            $table->boolean('rounded')->default(true)->nullable();
            $table->boolean('shadow')->default(false)->nullable();
            $table->boolean('centered')->default(false)->nullable();
            $table->string('default')->default(false)->nullable();
            $table->string('status')->default('active')->nullable();
            $table->foreign('domain')->references('domain')->on('domains')->onUpdate('cascade')->onDelete('cascade');
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
