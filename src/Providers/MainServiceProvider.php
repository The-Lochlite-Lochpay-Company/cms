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

namespace lochlite\cms\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Carbon\Carbon;
use Inertia\Inertia;
use lochlite\cms\Models\Settings;
use Illuminate\Filesystem\FilesystemManager;
use Artisan; use Storage; use URL; use Gate; use Session; use Config; use Cache;

class MainServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		@Jetstream::ignoreRoutes();
	   
	   $settings = Cache::get('settings', function () {
		     $listsettings = Settings::where('default', true)->orWhere('id', 1)->first();
             Cache::put('settings', $listsettings, now()->addHours(5));
			 return $listsettings;
        });
		Config::set('app.name', $settings->appname ?? 'App Name');
		Config::set('app.locale', $settings->language ?? 'pt');
		Config::set('app.url', $settings->domain ?? request()->getSchemeAndHttpHost());
		Config::set('app.timezone', $settings->timezone ?? 'America/Sao_Paulo');
		//Config::set('app.debug', $settings->debug ?? (bool) env('APP_DEBUG', false));
		Config::set('app.env', $settings->running ?? env('APP_ENV', 'production'));
		Config::set('backup.password', $settings->backup_key ?? env('BACKUP_ARCHIVE_PASSWORD', null));
		Config::set('backup.notifications.mail.to', $settings->backup_notify ?? env('BACKUP_NOTIFY_mail', null));
		Config::set('session.driver', $settings->session_driver ?? env('SESSION_DRIVER', 'database'));
		Config::set('session.lifetime', $settings->session_lifetime ?? env('SESSION_LIFETIME', 120));
		Config::set('broadcasting.default', $settings->broadcast_driver ?? env('BROADCAST_DRIVER', 'null'));
		Config::set('broadcasting.connections.pusher.key', $settings->pusher_app_key ?? '');
		Config::set('broadcasting.connections.pusher.secret', $settings->pusher_app_secret ?? '');
		Config::set('broadcasting.connections.pusher.app_id', $settings->pusher_app_id ?? '');
		Config::set('broadcasting.connections.options.cluster', $settings->pusher_app_cluster ?? '');
		Config::set('cache.default', $settings->cache_driver ?? env('CACHE_DRIVER', 'file'));
		Config::set('database.redis.default.url', $settings->redis_url ?? '');
		Config::set('database.redis.default.host', $settings->redis_host ?? '');
		Config::set('database.redis.default.port', $settings->redis_port ?? '');
		Config::set('database.redis.default.username', $settings->redis_username ?? '');
		Config::set('database.redis.default.password', $settings->redis_password ?? '');
		Config::set('database.redis.cache.url', $settings->redis_url ?? '');
		Config::set('database.redis.cache.host', $settings->redis_host ?? '');
		Config::set('database.redis.cache.port', $settings->redis_port ?? '');
		Config::set('database.redis.cache.username', $settings->redis_username ?? '');
		Config::set('database.redis.cache.password', $settings->redis_password ?? '');
		Config::set('mail.default', $settings->mail_driver ?? env('MAIL_MAILER', 'smtp'));
		Config::set('mail.from.name', $settings->mailfrom_name ?? '');
		Config::set('mail.from.address', $settings->mailfrom_address ?? '');
		Config::set('mail.mailers.smtp.host', $settings->mail_host ?? '127.0.0.1');
		Config::set('mail.mailers.smtp.port', $settings->mail_port ?? 587);
		Config::set('mail.mailers.smtp.username', $settings->mail_username ?? '');
		Config::set('mail.mailers.smtp.password', $settings->mail_password ?? '');
		Config::set('mail.mailers.smtp.encryption', $settings->mail_protocol ?? 'ssl');
		Config::set('mail.mailers.smtp.verify_peer', $settings->mail_encryption ?? true);
		Config::set('services.mailgun.domain', $settings->mailgun_domain ?? '');
		Config::set('services.mailgun.secret', $settings->mailgun_secret ?? '');
		Config::set('services.mailgun.endpoint', $settings->mailgun_endpoint ?? '');
		Config::set('services.mailgun.scheme', $settings->mailgun_scheme ?? '');
		Config::set('filesystems.default', $settings->filesystem_disk ?? env('FILESYSTEM_DISK', 'local'));
		Config::set('filesystems.disks.sftp.host', $settings->sftp_host ?? '');
		Config::set('filesystems.disks.sftp.username', $settings->sftp_username ?? '');
		Config::set('filesystems.disks.sftp.password', $settings->sftp_password ?? '');
		Config::set('filesystems.disks.sftp.privateKey', $settings->sftp_private_key ?? '');
		Config::set('filesystems.disks.ftp.host', $settings->ftp_host ?? '');
		Config::set('filesystems.disks.ftp.username', $settings->ftp_username ?? '');
		Config::set('filesystems.disks.ftp.password', $settings->ftp_password ?? '');
		Config::set('filesystems.disks.ftp.port', $settings->ftp_port ?? '');
		Config::set('filesystems.disks.ftp.ssl', $settings->ftp_ssl ?? '');
		Config::set('filesystems.disks.ftp.passive', $settings->ftp_passive ?? '');
		Config::set('filesystems.disks.ftp.timeout', $settings->ftp_timeout ?? '');
		Config::set('filesystems.disks.ftp.root', $settings->ftp_root ?? '');
		Config::set('filesystems.disks.s3.key', $settings->aws_access_key_id ?? '');
		Config::set('filesystems.disks.s3.secret', $settings->aws_secret_access_key ?? '');
		Config::set('filesystems.disks.s3.region', $settings->aws_default_region ?? '');
		Config::set('filesystems.disks.s3.bucket', $settings->aws_bucket ?? '');
		Config::set('filesystems.disks.s3.use_path_style_endpoint', $settings->aws_use_path_style_endpoint ?? '');
		Config::set('analytics.view_id', $settings->analytics_view_id ?? '');
		Config::set('newsletter.apiKey', $settings->mailchimp_api ?? '');
		Config::set('newsletter.lists.subscribers.id', $settings->mailchimp_list_id ?? '');

        Carbon::setLocale('pt_BR'); 
        Inertia::share([
            'appname' => Config::get('app.name'),
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
        ]);
  
        Inertia::share('flash', function () {
            return [
                'message' => Session::get('message'),
            ];
        });
         Storage::disk('local')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
             return URL::temporarySignedRoute(
                 'files.download',
                 $expiration,
                 array_merge($options, ['path' => $path])
             );
         });		
		
	}
}
