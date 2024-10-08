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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->string('title')->default('Register')->nullable();
            $table->string('description')->default("Create a new account")->nullable();
            $table->string('emphasis')->default('Create a new account')->nullable();
            $table->string('logintext')->default('Already have an account?')->nullable();
            $table->string('buttontext')->default('Sign up')->nullable();
            $table->string('buttoncolor')->default('bg-blue-600')->nullable();
            $table->string('buttontextcolor')->default('text-white')->nullable();
            $table->string('logo')->default('/application/72x72.png')->nullable();
            $table->string('image')->default('https://images.wallpaperscraft.com/image/single/city_night_aerial_view_154153_1600x900.jpg')->nullable();
            $table->json('form')->nullable();
            $table->boolean('imagevisible')->default(true)->nullable();
            $table->boolean('google')->default(false)->nullable();
            $table->string('googlereference')->nullable();
            $table->boolean('facebook')->default(false)->nullable();
            $table->string('facebookreference')->nullable();
            $table->boolean('twitter')->default(false)->nullable();
            $table->string('twitterreference')->nullable();
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
        Schema::dropIfExists('registers');
    }
};
