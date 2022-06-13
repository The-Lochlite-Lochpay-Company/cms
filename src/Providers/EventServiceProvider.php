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

namespace Lochlite\cms\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Lochlite\cms\Events\Update;
use Lochlite\cms\Listeners\UpdateListeners;
use Lochlite\cms\Events\RegisterPlugins;
use Lochlite\cms\Listeners\RegisterPluginsListeners;
use Lochlite\cms\Events\RegisterRoute;
use Lochlite\cms\Listeners\RegisterRouteListeners;

use Lochlite\cms\Events\Setupaccount;
use Lochlite\cms\Listeners\Setupaccountlisteners;
use Lochlite\cms\Listeners\Successfulloginlisteners;
use Lochlite\cms\Listeners\Failedloginlisteners;
use Lochlite\cms\Listeners\Authenticationattemptlisteners;
use Lochlite\cms\Listeners\Successfullogoutlisteners;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            Setupaccountlisteners::class,
        ],
        Login::class => [
            Successfulloginlisteners::class,
        ],
        Logout::class => [
            Successfullogoutlisteners::class,
        ],
        Attempting::class => [
            Authenticationattemptlisteners::class,
        ],
        Failed::class => [
            Failedloginlisteners::class,
        ],
        Setupaccount::class => [
            Setupaccountlisteners::class,
        ],		
        Update::class => [
            UpdateListeners::class,
        ],
        RegisterRoute::class => [
            RegisterRouteListeners::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

        parent::boot();
    }
}
