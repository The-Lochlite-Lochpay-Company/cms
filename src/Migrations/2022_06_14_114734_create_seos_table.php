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
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('post_id')->nullable();
			$table->unsignedBigInteger('page_id')->nullable();
            $table->string('domain')->nullable();
            $table->string('title')->default('Sem titulo')->nullable();
            $table->string('author')->default('Sem autor')->nullable();
            $table->string('description')->default('Sem descrição')->nullable();
            $table->string('keywords')->default('homepage, company, business')->nullable();
            $table->string('robots')->default('index,follow')->nullable();
            $table->string('translate')->default('translate')->nullable();
            $table->string('pdomain_verify')->nullable();
            $table->string('google_site_verification')->nullable();
            $table->string('ogtype')->default('website')->nullable();
            $table->string('ogurl')->nullable();
            $table->string('ogtitle')->default('Sem titulo')->nullable();
            $table->string('ogdescription')->default('Sem descrição')->nullable();
            $table->string('ogimage')->nullable();
            $table->string('fbapp_id')->nullable();
            $table->string('twittercard')->default('summary_large_image')->nullable();
            $table->string('twitterurl')->nullable();
            $table->string('twittertitle')->default('Sem titulo')->nullable();
            $table->string('twitterdescription')->default('Sem descrição')->nullable();
            $table->string('twitterimage')->nullable();
            $table->string('twittersite')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('default')->default(false)->nullable();
            $table->foreign('post_id')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('seos');
    }
};
