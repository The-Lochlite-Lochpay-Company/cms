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

namespace lochlite\cms\Controllers;

use Illuminate\Http\Request;
use lochlite\cms\Models\Pages;
use lochlite\cms\Models\Pagesbody;

use lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Carbon\Carbon; use Inertia\Inertia; use Response; use Cache; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;
use Lochlitecms;

class WelcomePagesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try{
		if(Pages::where('url', $id)->orWhere('id', $id)->exists()){	
        $page = Pages::where('url', $id)->orWhere('id', $id)->first();
        $pagebody = Pagesbody::where('page_id', $page->id)->first();
		 if(session()->has('views')){
		 if(!collect(session()->get('views'))->where('id', $page->id)->count() === 0){
			session()->push('views', ['id' => $page->id]);
			$page->update(['views' => intval($page->views) + 1]);
		 }
		 } else {
			session()->put('views', array());
			session()->push('views', ['id' => $page->id]);
			$page->update(['views' => intval($page->views) + 1]);
		 }	
        return Inertia::render('pagerendering', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => $page->title ?? 'Sem titulo',
             'page' => $page,
             'pagebody' => $pagebody,
             'version' => '2.0.5',
         ])->rootview('lochlitecms::app');
        } else {
        session()->flash('flash.banner', 'Página não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Página not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do página!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve página data')->setStatusCode(500);
        }
    }
}
