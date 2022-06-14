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

namespace Lochlite\cms;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Lochlite\cms\Jobs\RegisterRouteJob;
use Lochlite\cms\Models\User;
use Lochlite\cms\Models\Fileupload;
use Lochlite\cms\Models\Settings;
use Lochlite\cms\Models\Plugins;
use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Route; use File;

class Lochlitecms implements LochlitecmsInterface
{
    private static $instance;
	
    private $keypass, $module, $plugins='\plugins', $basePath;
	
    public function __construct($keypass=null)
    {
         $this->keypass = $keypass;
         $this->basePath = app()->path();
    }

    public function start($keypass=null) {
         return new Lochlitecms($keypass);
    }
	
    public function getInstance() {
         if(!isset(self::$instance)) {
		 return false;
         }
		 return self::$instance;
    }
	
    public static function setStaticInstance() {
         if(!isset(self::$instance)) {
		 self::$instance = new Lochlitecms();
         }
		 return self::$instance;
    }
	
    public function setInstance() {
         if(!isset(self::$instance)) {
		 self::$instance = new Lochlitecms();
         }
		 return self::$instance;
    }

    public function setKeypass(string $keypass)
    {
		$this->keypass = $keypass;
        return $this;
    }

    private function error(string $module, string $description, string $solution)
    {
        return collect(['success' => false, 'module' => $module, 'description' => $description, 'solution' => $solution]);
    }

    private function success(string $module, string $message=null)
    {
        return collect(['success' => true, 'module' => $module, 'message' => $message]);
    }

    public function application()
    {
        return collect(['name' => 'Lochlite CMS', 'version' => '2.0.8', 'madein' => 'Brazil', 'brand' => 'The Lochlite & Lochpay Company', 'manufacturer' => 'Lochlite e Lochpay Softwares e Pagamentos LTDA', 'license' => ['type' => 'private', 'name' => 'Proprietary', 'url' => 'https://djg.gpgic.com'], 'url_product' => 'https://lochlite.com/solutions/cms', 'homepage' => 'https://lochlite.com', 'developer' => ['name' => 'Igor Macedo Montalvão', 'contact' => ['email' => ['igor.macedo@gpgic.com', 'igmacedo01@gmail.com']]], 'support' => ['to' => 'drcg@gpgic.com', 'name' => 'Lochlite Technical Support', 'homepage' => 'https://drcg.gpgic.com']]);
    }

    public function listModule()
    {
        return collect(['setInstance', 'start', 'setKeypass', 'application', 'listModule', 'update', 'report', 'support', 'artisan', 'command', 'config', 'isFile', 'isFolder', 'existsFolder', 'getFolder', 'existsPluginsFolder', 'getPluginsFolder']);
    }

    public function update()
    {
		if(!is_null($this->keypass) && is_string($this->keypass)){
        return Lochlitecms::success('update', 'Updated successfully.');
		} else {
        return Lochlitecms::error('update', 'Keypass is missing, you must provide it before proceeding.', 'Use "new Lochlitecms($keypass)" or if using static method, use "Lochlitecms::setKeypass($keypass)" to solve this problem.');
		}
    }

    public function report($error=null)
    {
		if(is_null($error)){
        return Lochlitecms::error('report', 'A mandatory parameter is used, inform it before proceeding.', 'Use "new Lochlitecms($keypass)->report("your message here")" or if using static method, use "Lochlitecms::setKeypass($keypass)->report("your message here")" to resolve this problem.');
		} else if (!is_null($this->keypass) && is_string($this->keypass)){
        return Lochlitecms::error('report', 'Keypass is missing, you must provide it before proceeding.', 'Use "new Lochlitecms($keypass)" or if using static method, use "Lochlitecms::setKeypass($keypass)" to solve this problem.');
		} else {
        return Lochlitecms::success('report', 'Reported successfully.');
		}
    }

    public function support($message=null)
    {
		if(is_null($message)){
        return Lochlitecms::error('support', 'A mandatory parameter is used, inform it before proceeding.', 'Use "new Lochlitecms($keypass)->support("your message here")" or if using static method use "Lochlitecms::setKeypass($keypass)->support("your message here")" to resolve this problem.');
		} else if(is_null($this->keypass) && is_string($this->keypass)){
        return Lochlitecms::error('support', 'Keypass is missing, you must provide it before proceeding.', 'Use "new Lochlitecms($keypass)" or if using static method, use "Lochlitecms::setKeypass($keypass)" to solve this problem.');
		} else {
        return Lochlitecms::success('support', 'Support requested successfully.');
		}
    }

    public function artisan($command)
    {
        $result = Artisan::call($command);	   
        return collect(['success' => $result == 0 ? true : false, 'output' => Artisan::output()]);
    }

    public function command($command)
    {
        $result = shell_exec($command);	   
        return collect(['success' => $result == 0 ? true : false, 'output' => $result]);
    }

    public function config(String $param)
    {
		return Lochlitecms::settingsDatabase()->$param;
    }

    private function settingsDatabase()
    {
		if(\Schema::hasTable('settings') && Settings::where('default', true)->orWhere('id', 1)->exists()){
        return cache()->get('settings', function(){
			$setting = Settings::where('default', true)->orWhere('id', 1)->first();
			cache()->put($setting, 5000);
			return $setting;
		});	
	    } else {
			return (object) array(
			'appname' => 'App Name',
			'language' => 'pt',
			'domain' => request()->getSchemeAndHttpHost(),
			'timezone' => 'America/Sao_Paulo',
			'debug' => (bool) env('APP_DEBUG', true),
			'running' => env('APP_ENV', 'production'),
			'backup_key' => env('BACKUP_ARCHIVE_PASSWORD', null),
			'backup_notify' => env('BACKUP_NOTIFY_mail', null),
			'session_driver' => env('SESSION_DRIVER', 'database'),
			'session_lifetime' => env('SESSION_LIFETIME', 120),
			'broadcast_driver' => env('BROADCAST_DRIVER', 'null'),
			'pusher_app_key' => '',
			'pusher_app_secret' => '',
			'pusher_app_id' => '',
			'pusher_app_cluster' => '',
			'cache_driver' => env('CACHE_DRIVER', 'file'),
			'redis_url' => '',
			'redis_host' => '',
			'redis_port' => '',
			'redis_username' => '',
			'redis_password' => '',
			);
		}
    }

    public function startConfig()
    {
		$settings = Lochlitecms::settingsDatabase();
		Config()->set('app.name', $settings->appname);
		Config()->set('app.locale', $settings->language);
		Config()->set('app.url', $settings->domain);
		Config()->set('app.timezone', $settings->timezone);
		Config()->set('app.debug', $settings->debug);
		Config()->set('app.env', $settings->running);
		Config()->set('backup.password', $settings->backup_key);
		Config()->set('backup.notifications.mail.to', $settings->backup_notify);
		Config()->set('session.driver', $settings->session_driver);
		Config()->set('session.lifetime', $settings->session_lifetime);
		Config()->set('broadcasting.default', $settings->broadcast_driver);
		Config()->set('broadcasting.connections.pusher.key', $settings->pusher_app_key);
		Config()->set('broadcasting.connections.pusher.secret', $settings->pusher_app_secret);
		Config()->set('broadcasting.connections.pusher.app_id', $settings->pusher_app_id);
		Config()->set('broadcasting.connections.options.cluster', $settings->pusher_app_cluster);
		Config()->set('cache.default', $settings->cache_driver);
		Config()->set('database.redis.default.url', $settings->redis_url);
		Config()->set('database.redis.default.host', $settings->redis_host);
		Config()->set('database.redis.default.port', $settings->redis_port);
		Config()->set('database.redis.default.username', $settings->redis_username);
		Config()->set('database.redis.default.password', $settings->redis_password);
		Config()->set('database.redis.cache.url', $settings->redis_url);
		Config()->set('database.redis.cache.host', $settings->redis_host);
		Config()->set('database.redis.cache.port', $settings->redis_port);
		Config()->set('database.redis.cache.username', $settings->redis_username);
		Config()->set('database.redis.cache.password', $settings->redis_password);
		Config()->set('mail.default', $settings->mail_driver ?? env('MAIL_MAILER', 'smtp'));
		Config()->set('mail.from.name', $settings->mailfrom_name ?? '');
		Config()->set('mail.from.address', $settings->mailfrom_address ?? '');
		Config()->set('mail.mailers.smtp.host', $settings->mail_host ?? '127.0.0.1');
		Config()->set('mail.mailers.smtp.port', $settings->mail_port ?? 587);
		Config()->set('mail.mailers.smtp.username', $settings->mail_username ?? '');
		Config()->set('mail.mailers.smtp.password', $settings->mail_password ?? '');
		Config()->set('mail.mailers.smtp.encryption', $settings->mail_protocol ?? 'ssl');
		Config()->set('mail.mailers.smtp.verify_peer', $settings->mail_encryption ?? true);
		Config()->set('services.mailgun.domain', $settings->mailgun_domain ?? '');
		Config()->set('services.mailgun.secret', $settings->mailgun_secret ?? '');
		Config()->set('services.mailgun.endpoint', $settings->mailgun_endpoint ?? '');
		Config()->set('services.mailgun.scheme', $settings->mailgun_scheme ?? '');
		Config()->set('filesystems.default', $settings->filesystem_disk ?? env('FILESYSTEM_DISK', 'local'));
		Config()->set('filesystems.disks.sftp.host', $settings->sftp_host ?? '');
		Config()->set('filesystems.disks.sftp.username', $settings->sftp_username ?? '');
		Config()->set('filesystems.disks.sftp.password', $settings->sftp_password ?? '');
		Config()->set('filesystems.disks.sftp.privateKey', $settings->sftp_private_key ?? '');
		Config()->set('filesystems.disks.ftp.host', $settings->ftp_host ?? '');
		Config()->set('filesystems.disks.ftp.username', $settings->ftp_username ?? '');
		Config()->set('filesystems.disks.ftp.password', $settings->ftp_password ?? '');
		Config()->set('filesystems.disks.ftp.port', $settings->ftp_port ?? '');
		Config()->set('filesystems.disks.ftp.ssl', $settings->ftp_ssl ?? '');
		Config()->set('filesystems.disks.ftp.passive', $settings->ftp_passive ?? '');
		Config()->set('filesystems.disks.ftp.timeout', $settings->ftp_timeout ?? '');
		Config()->set('filesystems.disks.ftp.root', $settings->ftp_root ?? '');
		Config()->set('filesystems.disks.s3.key', $settings->aws_access_key_id ?? '');
		Config()->set('filesystems.disks.s3.secret', $settings->aws_secret_access_key ?? '');
		Config()->set('filesystems.disks.s3.region', $settings->aws_default_region ?? '');
		Config()->set('filesystems.disks.s3.bucket', $settings->aws_bucket ?? '');
		Config()->set('filesystems.disks.s3.use_path_style_endpoint', $settings->aws_use_path_style_endpoint ?? '');
		Config()->set('analytics.view_id', $settings->analytics_view_id ?? '');
		Config()->set('newsletter.apiKey', $settings->mailchimp_api ?? '');
		Config()->set('newsletter.lists.subscribers.id', $settings->mailchimp_list_id ?? '');
        return $this;
    }

    public function setConfig(String $module, Request $request)
    {
       try{
	     $setting = Settings::where('default', true)->orWhere('id', 1)->first(); 
         if($module == 'system'){
		   $setting->update([
		   'appname' => $request->get('appname'),
		   'domain' => $request->get('domain'),
		   'timezone' => $request->get('timezone'),
		   'language' => $request->get('language'),
		   'mail_driver' => $request->get('maildriver'),
		   'broadcast_driver' => $request->get('broadcastdriver'),
		   'session_driver' => $request->get('sessiondriver'),
		   'session_lifetime' => $request->get('sessionlifetime'),
		   'filesystem_disk' => $request->get('filesystemdisk'),
		   'cache_driver' => $request->get('cachedriver'),
		   'debug' => $request->get('debug'),
		   'running' => $request->get('running'),
		   ]);
		session()->flash('flash.banner', 'Configurações do sistema atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'backup'){
		   $setting->update([
		   'backup_key' => $request->get('key'),
		   'backup_notify' => $request->get('notify'),
		   ]);
		session()->flash('flash.banner', 'As configurações de backup foram atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'texteditor'){
		   $setting->update([
		   'text_editor' => $request->get('actived'),
		   ]);
		session()->flash('flash.banner', 'As configurações do editor de texto foram atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'email'){
		   $setting->update([
		   'mailfrom_name' => $request->get('emailfromname'),
		   'mailfrom_address' => $request->get('emailfrom'),
		   ]);
		session()->flash('flash.banner', 'Configurações de email atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'mailgun'){
		   $setting->update([
		   'mailgun_domain' => $request->get('mailgundomain'),
		   'mailgun_secret' => $request->get('mailgunsecret'),
		   'mailgun_endpoint' => $request->get('mailgunendpoint'),
		   'mailgun_scheme' => $request->get('mailgunscheme'),
		   ]);
		session()->flash('flash.banner', 'Configurações de Mailgun atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'smtp'){
		   $setting->update([
		   'mail_host' => $request->get('smtphost'),
		   'mail_port' => $request->get('smtpport'),
		   'mail_protocol' => $request->get('smtpprotocol'),
		   'mail_encryption' => $request->get('smtpencrypt'),
		   'mail_username' => $request->get('smtpusername'),
		   'mail_password' => $request->get('smtppassword'),
		   ]);
		session()->flash('flash.banner', 'Configurações de SMTP atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'mailchimp'){
		   $setting->update([
		   'mailchimp_api' => $request->get('mailchimpapi'),
		   'mailchimp_list_id' => $request->get('mailchimplistid'),
		   ]);
		session()->flash('flash.banner', 'Configurações de Mailchimp atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'googleanalytics'){
		   $setting->update([
		   'analytics_view_id' => $request->get('analyticsviewid'),
		   ]);
		session()->flash('flash.banner', 'Configurações do Google Analytics atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'ftp'){
		   $setting->update([
		   'ftp_host' => $request->get('ftphost'),
		   'ftp_username' => $request->get('ftpusername'),
		   'ftp_password' => $request->get('ftppassword'),
		   'ftp_port' => $request->get('ftpport'),
		   'ftp_ssl' => $request->get('ftpssl'),
		   'ftp_passive' => $request->get('ftppassive'),
		   'ftp_timeout' => $request->get('ftptimeout'),
		   'ftp_root' => $request->get('ftproot'),
		   ]);
		session()->flash('flash.banner', 'Configurações do FTP atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'sftp'){
		   $setting->update([
		   'sftp_host' => $request->get('sftphost'),
		   'sftp_username' => $request->get('sftpusername'),
		   'sftp_password' => $request->get('sftppassword'),
		   'sftp_private_key' => $request->get('sftpprivatekey'),
		   ]);
		session()->flash('flash.banner', 'Configurações do SFTP atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'amazon'){
		   $setting->update([
		   'aws_access_key_id' => $request->get('awskeyid'),
		   'aws_secret_access_key' => $request->get('awssecretkey'),
		   'aws_default_region' => $request->get('awsregion'),
		   'aws_bucket' => $request->get('awsbucket'),
		   ]);
		session()->flash('flash.banner', 'Configurações do Amazon S3 atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'memcached'){
		   $setting->update([
		   'memcached_host' => $request->get('memcachedhost'),
		   'memcached_port' => $request->get('memcachedport'),
		   'memcached_username' => $request->get('memcachedusername'),
		   'memcached_password' => $request->get('memcachedpassword'),
		   ]);
		session()->flash('flash.banner', 'Configurações do Memcached Server atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'redis'){
		   $setting->update([
		   'redis_url' => $request->get('redisurl'),
		   'redis_host' => $request->get('redishost'),
		   'redis_port' => $request->get('redisport'),
		   'redis_username' => $request->get('redisusername'),
		   'redis_password' => $request->get('redispassword'),
		   ]);
		session()->flash('flash.banner', 'Configurações do Redis Server atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'pusher'){
		   $setting->update([
		   'pusher_app_id' => $request->get('appid'),
		   'pusher_app_key' => $request->get('appkey'),
		   'pusher_app_secret' => $request->get('appsecret'),
		   'pusher_app_cluster' => $request->get('appcluster'),
		   ]);
		session()->flash('flash.banner', 'Configurações do Pusher atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
	   else {
        session()->flash('flash.banner', 'O Módulo: '. $module .' é invalido para o conjunto de configurações disponiveis atualmente.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Module not found.');
       }
	   $clearcache = Artisan::call('cache:clear');	   
       $clearconfig = Artisan::call('config:clear');	   
       return redirect()->back()->with('success','Settings updated successfully');
	   } catch(\Exception $e){
          session()->flash('flash.banner', 'Falha ao atualizar as configurações de: '. $module);
          session()->flash('flash.bannerStyle', 'danger');    
          return redirect()->back()->with('error','Failed to update settings');
       }

    }

    public function optimize(String $command)
    {
         try{
             if($command == 'cache'){
	          $operation = Lochlitecms::artisan('cache:clear');	   
		      session()->flash('flash.banner', 'O cache do CMS foi excluido com sucesso.');
              session()->flash('flash.bannerStyle', 'success');    
	         }
             else if($command == 'config'){
              $operation = Lochlitecms::artisan('config:clear');	   
		      session()->flash('flash.banner', 'O cache de configurações foi excluido com sucesso.');
              session()->flash('flash.bannerStyle', 'success');    
	         }
             else if($command == 'view'){
              $operation = Lochlitecms::artisan('view:clear');	   
		      session()->flash('flash.banner', 'O cache de renderização foi excluido com sucesso.');
              session()->flash('flash.bannerStyle', 'success');    
	         }
             else if($command == 'route'){
              $operation = Lochlitecms::artisan('route:clear');	   
		      session()->flash('flash.banner', 'O cache de rotas foi excludo com sucesso');
              session()->flash('flash.bannerStyle', 'success');    
	         }
             else if($command == 'cleanall'){
              $operation = Lochlitecms::artisan('optimize:clear');	   
		      session()->flash('flash.banner', 'O cache do site foi excludo com sucesso');
              session()->flash('flash.bannerStyle', 'success');    
	         }
             else if($command == 'optimize'){
              $operation = Lochlitecms::artisan('optimize');
		      session()->flash('flash.banner', 'O site foi otimizado com sucesso');
              session()->flash('flash.bannerStyle', 'success');    
	         }
	         else {
              session()->flash('flash.banner', 'O Módulo: '. $command .' é invalido para o conjunto de configurações disponiveis atualmente.');
              session()->flash('flash.bannerStyle', 'danger');    
              return redirect()->route('managersettings.cleandata')->with('error','Module not found.');
             }
	         
	         if($operation->get('success')){
               return redirect()->route('managersettings.cleandata')->with('success','Settings updated successfully');
	         } else {
               session()->flash('flash.banner', 'O modulo: '. $command .' retornou a seguinte mensagem: '. $operation->get('output'));
               session()->flash('flash.bannerStyle', 'danger');    
               return redirect()->route('managersettings.cleandata')->with('error','Settings updated failed');
	         }
	     } catch(\Exception $e){
            session()->flash('flash.banner', 'Ocorreu uma falha ao lidar com o modulo: '. $command);
            session()->flash('flash.bannerStyle', 'danger');    
            return redirect()->back()->with('error','Failed to update settings');
         }
    }

    public function render(String $view = 'Welcome', Array $data = [], String $layout = 'lochlitecms::admin')
    {
         return Inertia::render($view, $data)->rootview($layout);
    }

    public function renderAuth(String $view = 'Welcome', Array $data = [], String $layout = 'lochlitecms::admin')
    {
		 if(Auth()->guard('sanctum')->check() || Auth()->check()){
            return Inertia::render($view, $data)->rootview($layout);
	     } else {
            session()->flash('flash.banner', 'Você precisa fazer login ou registrar-se antes de continuar.');
            session()->flash('flash.bannerStyle', 'danger');    
		    return redirect()->route('login');	 
		 }
    }

    public function renderPanelCMS(String $view = 'Welcome', Array $data = [])
    {
		 if(Auth()->guard('sanctum')->check() || Auth()->check()){
            return Inertia::render($view, array_merge(['menuitems' => Lochlitecms::generateSidebar()], $data))->rootview('lochlitecms::admin');
	     } else {
            session()->flash('flash.banner', 'Você precisa fazer login ou registrar-se antes de continuar.');
            session()->flash('flash.bannerStyle', 'danger');    
		    return redirect()->route('login');	 
		 }
    }

    public function isFile($path)
    {
		 return File::isFile($path);
    }

    public function isFolder($path)
    {
		 return File::isDirectory($path);
    }

    public function existsFolder($path)
    {
         if(File::exists($path) && Lochlitecms::isFolder($path) === true){
		 return true;
         } else {
		 return false;
         }
    }

    public function getFolder($path, $param='')
    {    if(Lochlitecms::existsFolder($path)){
		 $provider = File::glob($path .'\*'. $param);
		 return File::file($provider[0])->dirname();
	     } else {
         return Lochlitecms::existsFolder($path);
		 }	 
    }

    public function FilesistemPlugin()
    {
		 return Storage::disk('plugins');
    }

    public function existsPluginsFolder()
    {
         return Lochlitecms::existsFolder(base_path('plugins'));
    }

    public function getPluginsFolder()
    {    if(Lochlitecms::existsPluginsFolder()){
         return Lochlitecms::FilesistemPlugin();
	     } else {
         return Lochlitecms::existsPluginsFolder();
		 }	 
    }

    private function processingNewPlugins()
    {
      $newplugin = false;		
      $registeredplugins = 0;		
      $failed = 0;		
      $total = 0;		
      $folders = File::directories(base_path('plugins'));
      foreach($folders as $item){
		 if(!Plugins::where('path', $item)->exists()){ 
         //Returns the absolute path of the first service provider it finds
         $path = collect(glob($item . DIRECTORY_SEPARATOR .'manifest.json'))->first();
		 if(!is_null($path)){
         $content = collect(json_decode(Storage::disk('plugins')->get(substr($item, strpos($item, 'plugins'. DIRECTORY_SEPARATOR) + 8).  DIRECTORY_SEPARATOR .'manifest.json'), true));
		 Plugins::create([
		 'path' => $item,
		 'namespace' => $content->get('namespace'),
		 'provider' => $content->get('provider'),
		 'version' => $content->get('version'),
		 'logo' => $content->get('logo'),
		 'screenshots' => $content->get('screenshots'),
		 'homepage' => $content->get('homepage'),
		 'authors' => $content->get('authors'),
		 'name' => $content->get('name'),
		 'description' => $content->get('description'),
		 'keywords' => $content->get('keywords'),
		 'license' => $content->get('license'),
		 'update' => $content->get('update'),
		 'keysecret' => $content->get('keysecret'),
		 ]);
	     $newplugin = true;
         } else {
			 $failed++;
		 }
	     $total++;
         }
      }
		 return collect(['newplugin' => $newplugin, 'added' => $registeredplugins, 'failed' => $failed, 'total' => $total]);
    }

    public function listPlugins()
    {
         Lochlitecms::processingNewPlugins();
         $plugins = Plugins::all();
		 return $plugins;
    }
	
	private function searchPluginProvider($item){
		 //Returns the absolute path of the first service provider it finds
         $str = collect(glob($item . '\\Providers\\*Provider.php'))->first();
         //Proceed with registration if the plugin has a service provider, otherwise continue the loop
         if(!is_null($str)){
         //Prepare the class name and namespace to be used
         $filter = pathinfo($str);
         $path = $filter['dirname'] .'\\'. $filter['filename'];
         $newclass = str_replace('.php', '', strstr($str, '\plugins'));
         return $newclass;
         }
		 return false;
	}

    public function startPlugins($app)
    {
      try{ 
      /**
      * For information on 'spl_autoload_register' see: https://www.php.net/manual/en/function.spl-autoload-register.php
      * For information on 'glob()' see: https://www.php.net/manual/en/function.glob.php
      * For information on 'app()' see: https://laravel.com/docs/9.x/helpers#method-app
      * base_path() returns the path of the plugins folder, something like: 'D:\www\laravel\plguins'
      * $name returns the namespace of the plugin's service provider, something like: '\plugins\plugin-name\Providers\PluginNameServiceProvider'
      * 'File::' is an abbreviation for the facade 'Illuminate\support\facades\File'
      **/
     if(Lochlitecms::existsPluginsFolder()){
		 
      //Import file if class not found
      spl_autoload_register(function ($name) {
         //Check if the file exists before importing it
         if(File::exists(base_path($name). '.php')){
         include(base_path($name). '.php');
         }
      });
      $plugins = Lochlitecms::listPlugins();
      //Iterates over a set of subfolders and accesses each one of them looking for a file with 'Provider.php' in the name
      foreach($plugins as $item){
         try{
         $newclass = $item->provider;
         if(!is_null($newclass)){
         //Register the plugin provider
         app()->register(new $newclass(app()));
		 if($item->status == 'processing'){$item->update(['status' => 'installed']); $item->save();}
         } else if($alternative = Lochlitecms::searchPluginProvider($item->path)){
         //Register the plugin provider
         app()->register(new $alternative(app()));
		 if($item->status == 'processing'){$item->update(['status' => 'installed']); $item->save();}
         }  
         } catch(\Exception $e){
             $item->update(['status' => 'failed']);  $item->update(['failedmessage' => $e->getMessage()]); $item->save();
         }

      }  
      }  
     } catch(\Exception $e){
         
     }

    }

    public static function upload(Request $request, string $input='file', string $disk='uploads', string $folder='uploads')
    {
        try{
        $currentfile = $request->file($input ?? 'file');
        $path = Storage::disk($disk ?? 'uploads')->putFile($folder ?? 'uploads', $currentfile);
        $url = Storage::disk($disk ?? 'uploads')->url($path);
        $size = Storage::disk($disk ?? 'uploads')->size($path);
        $name = $currentfile->getClientOriginalName();
        $type = $currentfile->getClientMimeType();
        $typesystem = $currentfile->getMimeType();
		
		return collect(['success' => true, 'path' => $path, 'url' => $url, 'size' => $size, 'name' => $name, 'type' => $type, 'typesystem' => $typesystem]);
		} catch(\Exception $e){
        return  collect(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public static function deleteUpload(string $path, string $disk='uploads')
    {
        try{
		if(Storage::disk($disk ?? 'uploads')->exists($path)){
        $result = Storage::disk($disk ?? 'uploads')->delete($path);
		return collect(['success' => true, 'exists' => true, 'result' => $result]);
        } else {
		return collect(['success' => true, 'exists' => false]);
		}
		
		} catch(\Exception $e){
        return  collect(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public static function setAvatar(Request $request)
    {
        try{
		if(Auth()->check()){	
        $user = Auth()->User();
		if(!empty($user->profile_photo_path) && Storage::disk('uploads')->exists($user->profile_photo_path)){
        Storage::disk('uploads')->delete($user->profile_photo_path);
		}
		if(!empty($user->profile_photo_path) && Fileupload::where('id', $user->id)->where('path', $user->profile_photo_path)->exists()){
        $removeavatar = Fileupload::where('id', $user->id)->where('path', $user->profile_photo_path)->first();
		$removeavatar->delete();
		}
		
        $currentfile = $request->file('file');
        $path = Storage::disk('uploads')->putFile('avatars', $currentfile);
        $url = Storage::disk('uploads')->url($path);
        $size = Storage::disk('uploads')->size($path);
        $name = $currentfile->getClientOriginalName();
        $type = $currentfile->getClientMimeType();
        $typesystem = $currentfile->getMimeType();

        $saveupload = Fileupload::create([
            'user_id' => Auth()->User()->id,
            'user_name' => Auth()->User()->name,
            'visitor' => $request->ip(),
            'filename' => $name,
            'size' => $size,
            'url' => $url,
            'path' => $path,
            'mimetype' => $type,
            'status' => 'success',
		]);

        $user->update([
		'avatar' => '/filing/'. now()->parse($saveupload->created_at)->toDateString(). '?url='. ($url ?? $user->avatar),
		'profile_photo_path' => $path ?? $user->profile_photo_path,
		]);
		
        return true;
        } else {
        return false;
        }
		} catch(\Exception $e){
        return $e->getMessage();
        }
	 
    }

    public static function deleteAvatar()
    {
        try{
		if(Auth()->check()){	
        $user = Auth()->User();
		if(!empty($user->profile_photo_path) && Storage::disk('uploads')->exists($user->profile_photo_path)){
        Storage::disk('uploads')->delete($user->profile_photo_path);
		}
		if(!empty($user->profile_photo_path) && Fileupload::where('id', $user->id)->where('path', $user->profile_photo_path)->exists()){
        $removeavatar = Fileupload::where('id', $user->id)->where('path', $user->profile_photo_path)->first();
		$removeavatar->delete();
		}
        $user->update(['avatar' => '', 'profile_photo_path' => '']);
        return true;
        } else {
        return false;
        }
		} catch(\Exception $e){
        return false;
        }
    }

    public static function cmsDisk()
    {
        config()->set('filesystems.disks', ['lochlitecms' => ['driver' => 'local', 'root' => base_path('lochlite\cms'), 'throw' => false]]);
		return Storage::disk('lochlitecms');	 
    }

    public function getRoutes()
    {
      try{ 
        $routes = cache()->get('routes', function(){
		    $database = \Lochlite\cms\Models\Routes::all();
			cache()->put('routes', $database, 1000);
			return $database;
		});
		
		foreach($routes as $item){
			if($item->type == 'resource'){
			app()->router->resource($item->url, $item->controller, ['middleware' => $item->middleware ?? ['web'], 'names' => $item->name ?? null, 'only' => $item->only ?? null, 'except' => $item->except ?? null]);	 
			} elseif($item->type == 'get'){
			app()->router->get($item->url, [$item->controller, $item->action ?? 'index'])->middleware($item->middleware ?? ['web'])->name($item->name ?? null);	 
			}  elseif($item->type == 'post'){
			app()->router->get($item->url, [$item->controller, $item->action ?? 'index'])->middleware($item->middleware ?? ['web'])->name($item->name ?? null);	 
			} else {
			app()->router->match($item->type, $item->url, [$item->controller, $item->action ?? 'index'])->middleware($item->middleware ?? ['web'])->name($item->name ?? null);	 
		    }
		}
	    return;
     } catch(\Exception $e){
         dd($e->getMessage());
     }
	 }

    public static function addRoutes(array $array)
    {
        RegisterRouteJob::dispatch($array);
    }

    public static function defaultRoutes()
    {
         lochlitecms::addRoutes([
         ['system' => true, 'type' => 'resource', 'url' => '/blog', 'controller' => \Lochlite\cms\Controllers\WelcomeBlogController::class, 'middleware' => ['web'], 'name' => 'blog'],
         ['system' => true, 'type' => 'get', 'url' => '/page/{id}', 'action' => 'index', 'controller' => \Lochlite\cms\Controllers\WelcomePagesController::class, 'middleware' => ['web'], 'name' => 'page.index'],
         ['system' => true, 'type' => 'resource', 'url' => '/dashboard', 'controller' => \Lochlite\cms\Controllers\HomeController::class, 'middleware' => ['web', 'auth:sanctum', config('jetstream.auth_session'), 'verified'], 'name' => 'dashboard', 'only' => ['index']],

         ['system' => true, 'type' => 'resource', 'url' => '/manager/dashboard', 'controller' => \Lochlite\cms\Controllers\Admin\AdminController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerdashboard'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/pages', 'controller' => \Lochlite\cms\Controllers\Admin\PagesController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerpages'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/posts', 'controller' => \Lochlite\cms\Controllers\Admin\PostsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerposts'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/notifications', 'controller' => \Lochlite\cms\Controllers\Admin\NotificationsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managernotifications'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/roles', 'controller' => \Lochlite\cms\Controllers\Admin\PermissionsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerroles'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/users', 'controller' => \Lochlite\cms\Controllers\Admin\UsersController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerusers'],
         ['system' => true, 'type' => 'post', 'url' => '/manager/comments/setapproved/{id}', 'action' => 'moderatesetapproved', 'controller' => \Lochlite\cms\Controllers\Admin\CommentsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managercomments.setapproved'],
         ['system' => true, 'type' => 'get', 'url' => '/manager/comments/moderate', 'action' => 'moderate', 'controller' => \Lochlite\cms\Controllers\Admin\CommentsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managercomments.moderate'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/comments', 'controller' => \Lochlite\cms\Controllers\Admin\CommentsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managercomments'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/contacts', 'controller' => \Lochlite\cms\Controllers\Admin\ContactsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managercontacts'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/feedbacks', 'controller' => \Lochlite\cms\Controllers\Admin\FeedbacksController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerfeedbacks'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/feedback-responses', 'controller' => \Lochlite\cms\Controllers\Admin\FeedbackresponsesController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerfeedback-responses'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/scheduling', 'controller' => \Lochlite\cms\Controllers\Admin\SchedulingController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerscheduling'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/storange', 'controller' => \Lochlite\cms\Controllers\Admin\StorangeController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerstorange'],
         ['system' => true, 'type' => 'get', 'url' => '/manager/storange/download/{id}', 'action' => 'download', 'controller' => \Lochlite\cms\Controllers\Admin\StorangeController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerstorange.download'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/emails', 'controller' => \Lochlite\cms\Controllers\Admin\EmailsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'manageremails'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/emailsmodel', 'controller' => \Lochlite\cms\Controllers\Admin\EmailsmodelController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'manageremailsmodel'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/plugins', 'controller' => \Lochlite\cms\Controllers\Admin\PluginsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerplugins'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/system', 'controller' => \Lochlite\cms\Controllers\Admin\SystemController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managersystem'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/routes', 'controller' => \Lochlite\cms\Controllers\Admin\RoutesController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerroutes'],
         ['system' => true, 'type' => 'resource', 'url' => '/manager/settings', 'controller' => \Lochlite\cms\Controllers\Admin\SettingsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managersettings', 'only' => ['index', 'store', 'update']],
         ['system' => true, 'type' => 'get', 'url' => '/manager/settings/cleandata', 'action' => 'cleandata', 'controller' => \Lochlite\cms\Controllers\Admin\SettingsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managersettings.cleandata'],
		   
         ['system' => true, 'type' => 'get', 'url' => '/filing/{date}', 'action' => 'filefiling', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'filefiling'],
         ['system' => true, 'type' => 'get', 'url' => '/download/{id}', 'action' => 'download', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'download'],
         ['system' => true, 'type' => 'get', 'url' => '/contact', 'action' => 'contact', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'contact'],
         ['system' => true, 'type' => 'post', 'url' => '/sendcontact', 'action' => 'sendcontact', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'sendcontact'],
         ['system' => true, 'type' => 'get', 'url' => '/feedback', 'action' => 'feedback', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'feedback'],
         ['system' => true, 'type' => 'post', 'url' => '/sendfeedback', 'action' => 'sendfeedback', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'sendfeedback'],
         ['system' => true, 'type' => 'post', 'url' => '/sendfeedback', 'action' => 'sendfeedback', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'sendfeedback'],
         ['system' => true, 'type' => 'post', 'url' => '/sendcomment/{id}', 'action' => 'sendcomment', 'controller' => \Lochlite\cms\Controllers\WelcomeBlogController::class, 'middleware' => ['web'], 'name' => 'sendcomment'],
         ['system' => true, 'type' => 'post', 'url' => '/sendvotes/{id}', 'action' => 'sendvotes', 'controller' => \Lochlite\cms\Controllers\WelcomeBlogController::class, 'middleware' => ['web'], 'name' => 'sendvotes'],
         ['system' => true, 'type' => 'post', 'url' => '/newsletter/subscript', 'action' => 'subscriptnewsletter', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'subscriptnewsletter'],
         ['system' => true, 'type' => 'get', 'url' => '/newsletter/unsubscribe/{email}', 'action' => 'unsubscribenewsletter', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'unsubscribenewsletter'],
         ['system' => true, 'type' => 'get', 'url' => '/', 'action' => 'index', 'controller' => \Lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'index.index'],
         ]);
    }

    public static function generateStylesheet(array $array)
    {
         foreach($array as $item){
	     try{ 	
         echo '<link rel="stylesheet" href="' .($item["href"] ?? ""). '" />';
	     } catch(\Exception $e){}	
	     }
    }

    public static function generateScript(array $array)
    {
         foreach($array as $item){
	     try{ 	
         echo '<script src="' .($item["src"] ?? ""). '"></script>';
	     } catch(\Exception $e){}	
	     }
    }

    public function generateSidebar()
    {
         return collect([
		 ['dropdown' => false, 'active' => request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('index.index'), 'id' => 'dashboard', 'url' => route('index.index'), 'icon' => 'menu-icon mdi mdi-television', 'name' => 'Dashboard'],
		 ['dropdown' => true, 'active' => (request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerposts.create') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerposts.index') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerpages.create') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerpages.index')), 'id' => 'pages', 'url' => '#pages', 'icon' => 'menu-icon mdi mdi-newspaper', 'name' => 'Páginas & Artigos',
		     'subitems' => [
		     ['url' => route('managerposts.create'), 'name' => 'Criar artigo'],
		     ['url' => route('managerpages.create'), 'name' => 'Criar página'],
		     ['url' => route('managerpages.index'), 'name' => 'Todas as páginas'],
		     ['url' => route('managerposts.index'), 'name' => 'Todos os artigos'],
			 ]
		 ],
		 ['dropdown' => true, 'active' => (request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managercomments.moderate') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managercomments.index')), 'id' => 'appearance', 'url' => '#appearance', 'icon' => 'menu-icon mdi mdi-palette', 'name' => 'Aparência',
		     'subitems' => [
		     ['url' => route('managercomments.moderate'), 'name' => 'Aprovar comentários'],
		     ['url' => route('managercomments.index'), 'name' => 'Todos os comentários'],
			 ]
		 ],
		 ['dropdown' => true, 'active' => (request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managercomments.moderate') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managercomments.index')), 'id' => 'comment', 'url' => '#comment', 'icon' => 'menu-icon mdi mdi-message-text', 'name' => 'Comentários',
		     'subitems' => [
		     ['url' => route('managercomments.moderate'), 'name' => 'Aprovar comentários'],
		     ['url' => route('managercomments.index'), 'name' => 'Todos os comentários'],
			 ]
		 ],
		 ['dropdown' => true, 'active' => (request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managersettings.index') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managersettings.cleandata')), 'id' => 'plugins', 'url' => '#plugins', 'icon' => 'menu-icon mdi mdi-apps', 'name' => 'Plugins',
		     'subitems' => [
		     ['url' => route('managerplugins.index'), 'name' => 'Gerenciar plugins'],
		     ['url' => route('managerplugins.index'), 'name' => 'Adicionar plugin'],
			 ]
		 ],
		 ['dropdown' => true, 'active' => (request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managersettings.index') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managersettings.cleandata') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managersystem.index')), 'id' => 'manager', 'url' => '#manager', 'icon' => 'menu-icon mdi mdi-security', 'name' => 'Administração do site',
		     'subitems' => [
		     ['url' => route('managerroutes.index'), 'name' => 'Gerenciar rotas'],
		     ['url' => route('managersettings.index'), 'name' => 'Configurações do sistema'],
		     ['url' => route('managersettings.cleandata'), 'name' => 'Dados armazenados'],
		     ['url' => route('managersystem.index'), 'name' => 'Informações do sistema'],
			 ]
		 ],
		 ['dropdown' => true, 'active' => (request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerstorange.index') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerstorange.create')), 'id' => 'storage', 'url' => '#storage', 'icon' => 'menu-icon mdi mdi-database', 'name' => 'Amazenamento',
		     'subitems' => [
		     ['url' => route('managerstorange.index'), 'name' => 'Todos os arquivos'],
		     ['url' => route('managerstorange.create'), 'name' => 'Fazer upload'],
			 ]
		 ],
		 ['dropdown' => true, 'active' => (request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('manageremails.index') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('manageremailsmodel.index') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('manageremails.create')), 'id' => 'email', 'url' => '#email', 'icon' => 'menu-icon mdi mdi-email', 'name' => 'Email',
		     'subitems' => [
		     ['url' => route('manageremails.index'), 'name' => 'Todos os emails'],
		     ['url' => route('manageremailsmodel.index'), 'name' => 'Modelos de email'],
		     ['url' => route('manageremails.create'), 'name' => 'Novo email'],
			 ]
		 ],
		 ['dropdown' => true, 'active' => (request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerusers.index') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerroles.index') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerroles.create') || request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerusers.create')), 'id' => 'users', 'url' => '#users', 'icon' => 'menu-icon mdi mdi-account-multiple', 'name' => 'Gestão de usuários',
		     'subitems' => [
		     ['url' => route('managerusers.index'), 'name' => 'Todos os usuários'],
		     ['url' => route('managerroles.index'), 'name' => 'Gestão De Permissões'],
		     ['url' => route('managerroles.create'), 'name' => 'Novo tipo de usuário'],
		     ['url' => route('managerusers.create'), 'name' => 'Cadastrar usuário'],
			 ]
		 ],
		 ['dropdown' => true, 'active' => request()->getSchemeAndHttpHost(). '/' .Route::current()->uri() == route('managerusers.index'), 'id' => 'support', 'url' => '#support', 'icon' => 'menu-icon mdi mdi-help-circle', 'name' => 'Suporte',
		     'subitems' => [
		     ['url' => route('managerusers.index'), 'name' => 'Manual de uso'],
		     ['url' => route('managerroles.index'), 'name' => 'Reportar um erro'],
		     ['url' => route('managerroles.index'), 'name' => 'Solicitar suporte'],
			 ]
		 ],
		 ]);
    }
	
	

}

