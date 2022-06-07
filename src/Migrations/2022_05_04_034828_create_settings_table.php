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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
			$table->string('appname')->default('App Name')->nullable();
			$table->string('domain')->nullable();
			$table->string('timezone')->default('America/Sao_Paulo')->nullable();
			$table->string('language')->default('pt_BR')->nullable();
			$table->string('mailfrom_name')->nullable();
			$table->string('mailfrom_address')->nullable();
			$table->string('mail_host')->nullable();
			$table->string('mail_port')->nullable();
			$table->string('mail_protocol')->nullable();
			$table->string('mail_encryption')->nullable();
			$table->string('mail_username')->nullable();
			$table->string('mail_password')->nullable();
			$table->string('mailgun_domain')->nullable();
			$table->string('mailgun_secret')->nullable();
			$table->string('mailgun_endpoint')->default('api.mailgun.net')->nullable();
			$table->string('mailgun_scheme')->default('https')->nullable();
			$table->string('mailchimp_api')->nullable();
			$table->string('mailchimp_list_id')->nullable();
			$table->string('analytics_view_id')->nullable();
			$table->string('lochlite_api_services')->nullable();
			$table->string('lochlite_api_update')->nullable();
			$table->string('sftp_host')->nullable();
			$table->string('sftp_username')->nullable();
			$table->string('sftp_password')->nullable();
			$table->string('sftp_private_key')->nullable();
			$table->string('ftp_host')->nullable();
			$table->string('ftp_username')->nullable();
			$table->string('ftp_password')->nullable();
			$table->integer('ftp_port')->default(21)->nullable();
			$table->boolean('ftp_ssl')->default(true)->nullable();
			$table->boolean('ftp_passive')->default(true)->nullable();
			$table->integer('ftp_timeout')->default(100)->nullable();
			$table->integer('ftp_root')->nullable();
			$table->string('aws_access_key_id')->nullable();
			$table->string('aws_secret_access_key')->nullable();
			$table->string('aws_default_region')->default('us-east-1')->nullable();
			$table->string('aws_bucket')->nullable();
			$table->string('aws_use_path_style_endpoint')->default('false')->nullable();
			$table->string('memcached_username')->nullable();
			$table->string('memcached_password')->nullable();
			$table->string('memcached_host')->default('127.0.0.1')->nullable();
			$table->integer('memcached_port')->default(11211)->nullable();
			$table->string('redis_url')->nullable();
			$table->string('redis_host')->default('127.0.0.1')->nullable();
			$table->string('redis_username')->nullable();
			$table->string('redis_password')->nullable();
			$table->integer('redis_port')->default(6369)->nullable();
			$table->string('pusher_app_id')->nullable();
			$table->string('pusher_app_key')->nullable();
			$table->string('pusher_app_secret')->nullable();
			$table->string('pusher_app_cluster')->default('mt1')->nullable();
			$table->string('mail_driver')->default('smtp')->nullable();
			$table->string('backup_key')->nullable();
			$table->string('backup_notify')->nullable();
			$table->string('broadcast_driver')->default('log')->nullable();
			$table->string('session_driver')->default('database')->nullable();
			$table->integer('session_lifetime')->default(120)->nullable();
			$table->string('filesystem_disk')->default('local')->nullable();
			$table->string('cache_driver')->default('file')->nullable();
			$table->boolean('text_editor')->default(true)->nullable();
			$table->boolean('debug')->default(false)->nullable();
			$table->string('running')->default('production')->nullable();
			$table->boolean('default')->default(false)->nullable();
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
        Schema::dropIfExists('settings');
    }
};
