<?php
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.9  
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

namespace Lochlite\cms\Controllers\Admin;

use Illuminate\Http\Request;
use Lochlite\cms\Models\Seo;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish seo|edit seo|delete seo', ['only' => ['index','show']]);
         $this->middleware('permission:publish seo', ['only' => ['create','store']]);
         $this->middleware('permission:edit seo', ['only' => ['edit','update']]);
         $this->middleware('permission:delete seo', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return Lochlitecms::renderPanelCMS('Panel/seo/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Configurações de Search Engine Optimization | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Configurações de Search Engine Optimization',
             'breadcrumbCurrentSection' => 'SEO',
             'seo' => Lochlitecms::seo(),
             'version' => Lochlitecms::application()->get('version'),
         ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Lochlitecms::seo()->update([
		'title' => $request->get('title'),
		'description' => $request->get('description'),
		'keywords' => $request->get('keywords'),
		'author' => $request->get('author'),
		'icon' => $request->get('favicon'),
		'robots' => $request->get('robots'),
		'translate' => $request->get('translate'),
		'pdomain_verify' => $request->get('pdomain_verify'),
		'google_site_verification' => $request->get('google_site_verification'),
		'twittercard' => $request->get('twittercard'),
		'twitterurl' => $request->get('twitterurl'),
		'twittertitle' => $request->get('twittertitle'),
		'twitterdescription' => $request->get('twitterdescription'),
		'twitterimage' => $request->get('twitterimage'),
		'twittersite' => $request->get('twittersite'),
		'ogtype' => $request->get('ogtype'),
		'ogurl' => $request->get('ogurl'),
		'ogtitle' => $request->get('ogtitle'),
		'ogdescription' => $request->get('ogdescription'),
		'ogimage' => $request->get('ogimage'),
		'fbapp_id' => $request->get('fbapp_id'),
		]);
    }
}
