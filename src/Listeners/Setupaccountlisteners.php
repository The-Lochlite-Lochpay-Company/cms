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

use Lochlite\cms\Events\Setupaccount;
use Lochlite\cms\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Lochlitecms;

class Setupaccountlisteners
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Setupaccount  $event
     * @return void
     */
    public function handle($event = null)
    {
		 if(is_null($event->user)){
         $user = Auth()->User();
         $id = $user->id;
		 } else {
         $user = $event->user;
         $id = $user->id;
		 }
		 if($user){
	        Lochlitecms::setHistory($action = 'register', $description = 'The user registered on the day: ' . now(), $user);       
			$user->assignRole('user');
			$user->save();
			if($user->hasRole('user')){
	        Lochlitecms::setHistory($action = 'accountSetup', $description = 'The system configured the user account on the day: ' . now(), $user);       
	        } else {
			Lochlitecms::setHistory($action = 'accountSetupFailed', $description = 'There was a failure to configure the user account on the day: ' . now(), $user);       				
			}
		 }
    }
}