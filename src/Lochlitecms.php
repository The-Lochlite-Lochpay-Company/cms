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

namespace lochlite\cms;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use lochlite\cms\Jobs\RegisterRouteJob;
use lochlite\cms\Models\User;
use lochlite\cms\Models\Fileupload;
use Artisan; use Storage; use Route; use File;

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
        return collect(['name' => 'Lochlite CMS', 'version' => '2.0.7', 'madein' => 'Brazil', 'brand' => 'The Lochlite & Lochpay Company', 'manufacturer' => 'Lochlite e Lochpay Softwares e Pagamentos LTDA', 'license' => ['type' => 'private', 'name' => 'Proprietary', 'url' => 'https://djg.gpgic.com'], 'url_product' => 'https://lochlite.com/solutions/cms', 'homepage' => 'https://lochlite.com', 'developer' => ['name' => 'Igor Macedo Montalvão', 'contact' => ['email' => ['igor.macedo@gpgic.com', 'igmacedo01@gmail.com']]], 'support' => ['to' => 'drcg@gpgic.com', 'name' => 'Lochlite Technical Support', 'homepage' => 'https://drcg.gpgic.com']]);
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

    public function config($param=false)
    {
		if($param){
        return config()->get('lochlite.' .$param);
	    } else {
        return config()->get('lochlite');
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
     
      //Import file if class not found
      spl_autoload_register(function ($name) {
         //Check if the file exists before importing it
         if(File::exists(base_path($name). '.php')){
         include(base_path($name). '.php');
         }
      });
     
      //Access the plugins folder and list the directories
      $folders = File::directories(base_path('plugins'));
     
      //Iterates over a set of subfolders and accesses each one of them looking for a file with 'Provider.php' in the name
      foreach($folders as $item){
         //Returns the absolute path of the first service provider it finds
         $str = collect(glob($item . '\\Providers\\*Provider.php'))->first();
         
         //Proceed with registration if the plugin has a service provider, otherwise continue the loop
         if(!is_null($str)){
     
         //Prepare the class name and namespace to be used
         $filter = pathinfo($str);
         $path = $filter['dirname'] .'\\'. $filter['filename'];
         $newclass = str_replace('.php', '', strstr($str, '\plugins'));
         
         //Register the plugin provider
         app()->register(new $newclass(app()));
         }
      }  
     } catch(\Exception $e){
         dd($e->getMessage());
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
			cache()->put('routes', collect(), 100);
			return cache()->get('routes');
		});
		foreach($routes as $item){
			if(!is_array($item->get('type')) && $item->get('type') == 'resource'){
			app()->router->resource($item->get('url'), $item->get('controller'), ['middleware' => $item->get('middleware') ?? ['web'], 'names' => $item->get('name') ?? null, 'only' => $item->get('only') ?? null, 'except' => $item->get('except') ?? null]);	 
			} else {
			app()->router->match($item->get('type'), $item->get('url'), [$item->get('controller'), $item->get('action')])->middleware($item->get('middleware') ?? ['web'])->name($item->get('name') ?? null);	 
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
         ['type' => 'resource', 'url' => '/blog', 'controller' => \lochlite\cms\Controllers\WelcomeBlogController::class, 'middleware' => ['web'], 'name' => 'blog'],
         ['type' => 'resource', 'url' => '/page', 'controller' => \lochlite\cms\Controllers\WelcomePagesController::class, 'middleware' => ['web'], 'name' => 'page', 'only' => ['index']],
         ['type' => 'resource', 'url' => '/dashboard', 'controller' => \lochlite\cms\Controllers\HomeController::class, 'middleware' => ['web', 'auth:sanctum', config('jetstream.auth_session'), 'verified'], 'name' => 'dashboard', 'only' => ['index']],

         ['type' => 'resource', 'url' => '/manager/dashboard', 'controller' => \lochlite\cms\Controllers\Admin\AdminController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerdashboard'],
         ['type' => 'resource', 'url' => '/manager/pages', 'controller' => \lochlite\cms\Controllers\Admin\PagesController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerpages'],
         ['type' => 'resource', 'url' => '/manager/posts', 'controller' => \lochlite\cms\Controllers\Admin\PostsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerposts'],
         ['type' => 'resource', 'url' => '/manager/notifications', 'controller' => \lochlite\cms\Controllers\Admin\NotificationsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managernotifications'],
         ['type' => 'resource', 'url' => '/manager/roles', 'controller' => \lochlite\cms\Controllers\Admin\PermissionsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerroles'],
         ['type' => 'resource', 'url' => '/manager/users', 'controller' => \lochlite\cms\Controllers\Admin\UsersController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerusers'],
         ['type' => ['POST', 'PATH'], 'url' => '/manager/comments/setapproved/{id}', 'action' => 'moderatesetapproved', 'controller' => \lochlite\cms\Controllers\Admin\CommentsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managercomments.setapproved'],
         ['type' => ['GET', 'HEAD'], 'url' => '/manager/comments/moderate', 'action' => 'moderate', 'controller' => \lochlite\cms\Controllers\Admin\CommentsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managercomments.moderate'],
         ['type' => 'resource', 'url' => '/manager/comments', 'controller' => \lochlite\cms\Controllers\Admin\CommentsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managercomments'],
         ['type' => 'resource', 'url' => '/manager/contacts', 'controller' => \lochlite\cms\Controllers\Admin\ContactsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managercontacts'],
         ['type' => 'resource', 'url' => '/manager/feedbacks', 'controller' => \lochlite\cms\Controllers\Admin\FeedbacksController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerfeedbacks'],
         ['type' => 'resource', 'url' => '/manager/feedback-responses', 'controller' => \lochlite\cms\Controllers\Admin\FeedbackresponsesController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerfeedback-responses'],
         ['type' => 'resource', 'url' => '/manager/scheduling', 'controller' => \lochlite\cms\Controllers\Admin\SchedulingController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerscheduling'],
         ['type' => 'resource', 'url' => '/manager/storange', 'controller' => \lochlite\cms\Controllers\Admin\StorangeController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerstorange'],
         ['type' => ['GET', 'HEAD'], 'url' => '/manager/storange/download/{id}', 'action' => 'download', 'controller' => \lochlite\cms\Controllers\Admin\StorangeController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managerstorange.download'],
         ['type' => 'resource', 'url' => '/manager/emails', 'controller' => \lochlite\cms\Controllers\Admin\EmailsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'manageremails'],
         ['type' => 'resource', 'url' => '/manager/emailsmodel', 'controller' => \lochlite\cms\Controllers\Admin\EmailsmodelController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'manageremailsmodel'],
         ['type' => 'resource', 'url' => '/manager/settings', 'controller' => \lochlite\cms\Controllers\Admin\SettingsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managersettings'],
         ['type' => ['GET', 'HEAD'], 'url' => '/manager/settings/cleandata', 'action' => 'cleandata', 'controller' => \lochlite\cms\Controllers\Admin\SettingsController::class, 'middleware' => ['web', 'auth:sanctum'], 'name' => 'managersettings.cleandata'],

         ['type' => ['GET', 'HEAD'], 'url' => '/filing/{date}', 'action' => 'filefiling', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'filefiling'],
         ['type' => ['GET', 'HEAD'], 'url' => '/download/{id}', 'action' => 'download', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'download'],
         ['type' => ['GET', 'HEAD'], 'url' => '/contact', 'action' => 'contact', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'contact'],
         ['type' => ['POST', 'PATH'], 'url' => '/sendcontact', 'action' => 'sendcontact', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'sendcontact'],
         ['type' => ['GET', 'HEAD'], 'url' => '/feedback', 'action' => 'feedback', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'feedback'],
         ['type' => ['POST', 'PATH'], 'url' => '/sendfeedback', 'action' => 'sendfeedback', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'sendfeedback'],
         ['type' => ['POST', 'PATH'], 'url' => '/sendfeedback', 'action' => 'sendfeedback', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'sendfeedback'],
         ['type' => ['POST', 'PATH'], 'url' => '/sendcomment/{id}', 'action' => 'sendcomment', 'controller' => \lochlite\cms\Controllers\WelcomeBlogController::class, 'middleware' => ['web'], 'name' => 'sendcomment'],
         ['type' => ['POST', 'PATH'], 'url' => '/sendvotes/{id}', 'action' => 'sendvotes', 'controller' => \lochlite\cms\Controllers\WelcomeBlogController::class, 'middleware' => ['web'], 'name' => 'sendvotes'],
         ['type' => ['POST', 'PATH'], 'url' => '/newsletter/subscript', 'action' => 'subscriptnewsletter', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'subscriptnewsletter'],
         ['type' => ['GET', 'HEAD'], 'url' => '/newsletter/unsubscribe/{email}', 'action' => 'unsubscribenewsletter', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'unsubscribenewsletter'],
         ['type' => 'resource', 'url' => '/', 'controller' => \lochlite\cms\Controllers\WelcomeController::class, 'middleware' => ['web'], 'name' => 'index', 'only' => ['index']],
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
	
	

}

