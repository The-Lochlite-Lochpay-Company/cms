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

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use lochlite\cms\Providers\MainServiceProvider;
use lochlite\cms\Providers\EventServiceProvider;
use lochlite\cms\Providers\RouteServiceProvider;
use lochlite\cms\Jobs\UpdateJob;
use lochlite\cms\Events\RegisterPlugins;
use Gate;

class LochlitecmsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('lochlitecms', function($app) {
            $package = new Lochlitecms();
			return $package->setInstance();
        });
        $this->app->register(MainServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->booted(function () {
        $this->app->register(RouteServiceProvider::class);
             $schedule = $this->app->make(Schedule::class);
             $schedule->job(new UpdateJob('2.0.6'))->daily();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

     Gate::before(function ($user, $ability) {
         if ($user->hasRole('Admin')) {
             return true;
         }
     });
     $this->loadMigrationsFrom(__DIR__ . './Migrations');
     $this->loadViewsFrom(__DIR__ . './Views', 'lochlitecms');
     $this->loadRoutesFrom(__DIR__ . './Routes/web.php');
	 $instanceCMS = lochlitecms::setStaticInstance();	
     $instanceCMS->defaultRoutes();
     $instanceCMS->startPlugins(app());
     $instanceCMS->getRoutes();
    }
}
