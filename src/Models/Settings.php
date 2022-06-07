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

namespace lochlite\cms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
	'appname',
	'domain',
	'timezone',
	'mailfrom_name',
	'mailfrom_address',
	'mail_host',
	'mail_port',
	'mail_protocol',
	'mail_encryption',
	'mail_username',
	'mail_password',
	'mailgun_domain',
	'mailgun_secret',
	'mailgun_endpoint',
	'mailgun_scheme',
	'mailchimp_api',
	'mailchimp_list_id',
	'analytics_view_id',
	'lochlite_api_services',
	'lochlite_api_update',
	'sftp_host',
	'sftp_username',
	'sftp_password',
	'sftp_private_key',
	'ftp_host',
	'ftp_username',
	'ftp_password',
	'ftp_port',
	'ftp_ssl',
	'ftp_passive',
	'ftp_timeout',
	'ftp_root',
	'aws_access_key_id',
	'aws_secret_access_key',
	'aws_default_region',
	'aws_bucket',
	'aws_use_path_style_endpoint',
	'memcached_username',
	'memcached_password',
	'memcached_host',
	'memcached_port',
	'redis_url',
	'redis_host',
	'redis_username',
	'redis_password',
	'redis_port',
	'pusher_app_id',
	'pusher_app_key',
	'pusher_app_secret',
	'pusher_app_cluster',
	'backup_key',
	'mail_driver',
	'broadcast_driver',
	'session_driver',
	'session_lifetime',
	'filesystem_disk',
	'cache_driver',
	'text_editor',
	'debug',
	'running',
	'default',
	'status',
    ];	
}
