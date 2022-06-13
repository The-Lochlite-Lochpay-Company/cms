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
        Schema::create('updates', function (Blueprint $table) {
            $table->id();
			$table->string('version')->default('2.0.5')->nullable();
			$table->string('lastversion')->default('2.0.5')->nullable();
			$table->string('path')->nullable();
			$table->string('backup')->nullable();
			$table->longText('description')->nullable();
			$table->string('status')->default('processing')->nullable();
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
        Schema::dropIfExists('updates');
    }
};
