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

namespace Lochlite\cms\Listeners;

use Lochlite\cms\Events\RegisterRoute;
use Lochlite\cms\Models\Routes;
use Lochlite\cms\Lochlitecms;
use File; use Artisan;

class RegisterRouteListeners
{
    public function handle(RegisterRoute $event)
    {
         $array = $event->array;
         try{ 
		     $newroute = false;
		     $routecache = true;
             $routes = cache()->get('routes', function(){
		        $routecache = false;
		        $database = Routes::all();
		     	cache()->put('routes', $database, 1000);
		     	return $database;
		     }); 
		     if($routecache){
             foreach($array as $item){
		          if (!Routes::where('url', $item['url'])->exists()) {
		              $newroute = true; 
		              $typeroute = $item['type'] ?? 'resource';
					  $thisroute = Routes::create(['type' => $typeroute, 'url' => $item['url'], 'controller' => $item['controller'] ?? '\lochlite\cms\Controllers\WelcomeController', 'middleware' => $item['middleware'] ?? ['web'], 'name' => $item['name'] ?? null, 'only' => $item['only'] ?? null, 'except' => $item['except'] ?? null, 'action' => $item['action'] ?? 'index']);
                  }
             }
	         if($newroute){
		         cache()->put('routes', Routes::all(), 1000);
				 Artisan::call('route:clear');
				 Artisan::call('route:cache');
             }
             }
         } catch(\Exception $e){
             //
         }
    }
}