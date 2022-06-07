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

namespace lochlite\cms\Controllers\Admin;

use Illuminate\Http\Request;
use lochlite\cms\Models\Settings;

use lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish system|edit system|delete system', ['only' => ['index','show']]);
         $this->middleware('permission:publish system', ['only' => ['create','store']]);
         $this->middleware('permission:edit system', ['only' => ['edit','update','cleandata']]);
         $this->middleware('permission:delete system', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Settings::where('domain', request()->getHttpHost())->orWhere('default', true)->first();
		 if (request()->wantsJson()) {
           return $posts;
         }
         return Inertia::render('Panel/settings/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Configurações do sistema | Lochlite CMS',
             'user' => Auth::User(),
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Configurações do sistema',
             'breadcrumbCurrentSection' => 'Configurações',
             'settings' => $settings,
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cleandata()
    {
         return Inertia::render('Panel/settings/cleandata', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Configurações do sistema | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'user' => Auth::User(),
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Configurações do sistema',
             'breadcrumbCurrentSection' => 'Configurações',
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
       try{
	   $module = $request->get('module');
       if($module == 'cache'){
	    $operation = lochlitecms::artisan('cache:clear');	   
		session()->flash('flash.banner', 'O cache do CMS foi excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'config'){
        $operation = lochlitecms::artisan('config:clear');	   
		session()->flash('flash.banner', 'O cache de configurações foi excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'view'){
        $operation = lochlitecms::artisan('view:clear');	   
		session()->flash('flash.banner', 'O cache de renderização foi excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'route'){
        $operation = lochlitecms::artisan('route:clear');	   
		session()->flash('flash.banner', 'O cache de rotas foi excludo com sucesso');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'cleanall'){
        $operation = lochlitecms::artisan('optimize:clear');	   
		session()->flash('flash.banner', 'O cache do site foi excludo com sucesso');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'optimize'){
        $operation = lochlitecms::artisan('optimize');
		session()->flash('flash.banner', 'O site foi otimizado com sucesso');
        session()->flash('flash.bannerStyle', 'success');    
	   }
	   else {
        session()->flash('flash.banner', 'O Módulo: '. $module .' é invalido para o conjunto de configurações disponiveis atualmente.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('managersettings.cleandata')->with('error','Module not found.');
       }
	   
	   if($operation->get('success')){
         return redirect()->route('managersettings.cleandata')->with('success','Settings updated successfully');
	   } else {
         session()->flash('flash.banner', 'O modulo: '. $module .' retornou a seguinte mensagem: '. $operation->get('output'));
         session()->flash('flash.bannerStyle', 'danger');    
         return redirect()->route('managersettings.cleandata')->with('error','Settings updated failed');
	   }
	   
	   } catch(\Exception $e){dd($e->getMessage());
          session()->flash('flash.banner', 'Ocorreu uma falha ao lidar com o modulo: '. $module);
          session()->flash('flash.bannerStyle', 'danger');    
          return redirect()->back()->with('error','Failed to update settings');
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $module)
    {
       try{
       if($module == 'system'){
		   Settings::where('id', 1)->first()->update([
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
		   Settings::where('id', 1)->first()->update([
		   'backup_key' => $request->get('key'),
		   'backup_notify' => $request->get('notify'),
		   ]);
		session()->flash('flash.banner', 'As configurações de backup foram atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'texteditor'){
		   Settings::where('id', 1)->first()->update([
		   'text_editor' => $request->get('actived'),
		   ]);
		session()->flash('flash.banner', 'As configurações do editor de texto foram atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'email'){
		   Settings::where('id', 1)->first()->update([
		   'mailfrom_name' => $request->get('emailfromname'),
		   'mailfrom_address' => $request->get('emailfrom'),
		   ]);
		session()->flash('flash.banner', 'Configurações de email atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'mailgun'){
		   Settings::where('id', 1)->first()->update([
		   'mailgun_domain' => $request->get('mailgundomain'),
		   'mailgun_secret' => $request->get('mailgunsecret'),
		   'mailgun_endpoint' => $request->get('mailgunendpoint'),
		   'mailgun_scheme' => $request->get('mailgunscheme'),
		   ]);
		session()->flash('flash.banner', 'Configurações de Mailgun atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'smtp'){
		   Settings::where('id', 1)->first()->update([
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
		   Settings::where('id', 1)->first()->update([
		   'mailchimp_api' => $request->get('mailchimpapi'),
		   'mailchimp_list_id' => $request->get('mailchimplistid'),
		   ]);
		session()->flash('flash.banner', 'Configurações de Mailchimp atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'googleanalytics'){
		   Settings::where('id', 1)->first()->update([
		   'analytics_view_id' => $request->get('analyticsviewid'),
		   ]);
		session()->flash('flash.banner', 'Configurações do Google Analytics atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'ftp'){
		   Settings::where('id', 1)->first()->update([
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
		   Settings::where('id', 1)->first()->update([
		   'sftp_host' => $request->get('sftphost'),
		   'sftp_username' => $request->get('sftpusername'),
		   'sftp_password' => $request->get('sftppassword'),
		   'sftp_private_key' => $request->get('sftpprivatekey'),
		   ]);
		session()->flash('flash.banner', 'Configurações do SFTP atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'amazon'){
		   Settings::where('id', 1)->first()->update([
		   'aws_access_key_id' => $request->get('awskeyid'),
		   'aws_secret_access_key' => $request->get('awssecretkey'),
		   'aws_default_region' => $request->get('awsregion'),
		   'aws_bucket' => $request->get('awsbucket'),
		   ]);
		session()->flash('flash.banner', 'Configurações do Amazon S3 atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'memcached'){
		   Settings::where('id', 1)->first()->update([
		   'memcached_host' => $request->get('memcachedhost'),
		   'memcached_port' => $request->get('memcachedport'),
		   'memcached_username' => $request->get('memcachedusername'),
		   'memcached_password' => $request->get('memcachedpassword'),
		   ]);
		session()->flash('flash.banner', 'Configurações do Memcached Server atualizadas com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
	   }
       else if($module == 'redis'){
		   Settings::where('id', 1)->first()->update([
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
		   Settings::where('id', 1)->first()->update([
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
