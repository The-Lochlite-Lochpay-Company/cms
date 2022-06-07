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

use lochlite\cms\Events\Historyaccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use lochlite\cms\Models\User;
use lochlite\cms\Models\History;

class Historyaccountlisteners
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
     * @param  \App\Events\Historyaccount  $event
     * @return void
     */
    public function handle(Historyaccount $event)
    {
         $user = $event->user;
         $id = $user->id;
         $name = $user->name;
         $action = $event->action;
         $description = $event->description;
         $history = History::create([
            'userid' => $id,
            'username' => $name,
            'ip' => session()->get('ip'),
            'agent' => session()->get('browser'),
            'device' => session()->get('device'),
            'system' => session()->get('system'),
            'city' => session()->get('city'),
            'state' => session()->get('states'),
            'country' => session()->get('country'),
            'longitude' => session()->get('longitude'),
            'latitude' => session()->get('latitude'),
            'url' => url()->current(),
            'urlprevious' => url()->previous(),
            'action' => $action,
            'description' => $description,
         ]);
		return $history;
    }
}
