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
        Schema::create('appendcodings', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('userid');
			$table->longText('comment')->nullable();
			$table->longText('body')->nullable();
			$table->longText('integrity')->nullable();
			$table->longText('hash')->nullable();
            $table->string('position')->default('head')->nullable();
            $table->string('status')->default('disable')->nullable();
            $table->foreign('userid')->references('id')->on('users');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE appendcodings MODIFY body LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appendcodings');
    }
};
