<?php
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.7  
* License: Proprietary
* Made in: Brazil
* Author: The Lochlite & Lochpay Company
* Developer: IGOR MACEDO MONTALVÃO
* Website: https://lochlite.com | https://lochpay.com | https://gpgic.com 
* Support: drcg@gpgic.com | drcg@lochlite.com | drcl@lochlite.com
*
* LEGAL NOTICE: The author(s) of the software grants the user of the software a personal, non-transferable, limited and revocable license without the right to market, resell, distribute, clone or recycle the software; The author(s) reserve the right to renew, revoke or modify the license, as well as impose fines for its violation at its most reasonable discretion.
*
* DISCLAIMER: The author(s) of the Software will not be responsible for any physical, moral, property damages or of any nature due to the software, its enjoyment or risks up to the limits of the legislation in force in Brazil.
*
* ('Art. 43 - LEI No 4.502/1964' - law of brazil) Indústria Brasileira - LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA, CNPJ: 37.816.728/0001-04; Address: SCS QUADRA 9, BLOCO C, 10 ANDAR, SALA 1003, Brasilia, Federal District, Brazil, Zip Code: 70308-200
**/

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
        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('namespace')->nullable();
            $table->string('name')->default('unknown')->nullable();
            $table->longText('description')->nullable();
            $table->longText('failedmessage')->nullable();
            $table->json('authors')->nullable();
            $table->json('keywords')->nullable();
            $table->json('screenshots')->nullable();
            $table->string('logo')->nullable();
            $table->string('homepage')->nullable();
            $table->json('support')->nullable();
            $table->string('provider')->nullable();
            $table->string('path')->nullable();
            $table->string('version')->default('1.0')->nullable();
            $table->string('last_version')->nullable();
            $table->string('update')->nullable();
            $table->string('keysecret')->nullable();
            $table->string('license')->default('MIT')->nullable();
            $table->string('status')->default('processing')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('plugins');
    }
};
