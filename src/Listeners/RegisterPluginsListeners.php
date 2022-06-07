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

namespace lochlite\cms\Listeners;

use lochlite\cms\Events\RegisterPlugins;
use lochlite\cms\lochlitecms;
 use File;

class RegisterPluginsListeners
{
    public function handle(RegisterPlugins $event)
    {
        $app = $event->app;
         spl_autoload_register(function ($name) {
			if(File::exists(base_path($name). '.php')){
            include(base_path($name). '.php');
			}
         }); 
		 $folder = collect(File::directories(base_path('plugins')));
		 foreach($folder as $item){
		 	$str = collect(glob($item . '\\Providers\\*Provider.php'))->first();
		 	$filter = pathinfo($str);
		 	$path = $filter['dirname'] .'\\'. $filter['filename'];
		 	$newclass = str_replace('.php', '', strstr($str, '\plugins'));
			$app->register(new $newclass(app()));
        }		
    }
}