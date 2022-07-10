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

namespace Lochlite\cms\Controllers\Admin;

use Illuminate\Http\Request;
use Lochlite\cms\Models\Settings;
use Lochlite\cms\Models\Posts;
use Lochlite\cms\Models\Postsbody;
use Spatie\Sitemap\Sitemap;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class PwaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish pwa|edit pwa|delete pwa', ['only' => ['index','show']]);
         $this->middleware('permission:publish pwa', ['only' => ['create','store']]);
         $this->middleware('permission:edit pwa', ['only' => ['edit','update']]);
         $this->middleware('permission:delete pwa', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return Lochlitecms::renderPanelCMS('Panel/pwa/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Configurações de PWA | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Configurações de PWA ',
             'breadcrumbCurrentSection' => 'PWA',
             'pwa' => Lochlitecms::pwa(),
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
        Lochlitecms::pwa()->update([
		'background_color' => $request->get('background_color'),
		'theme_color' => $request->get('theme_color'),
		'name' => $request->get('name'),
		'short_name' => $request->get('short_name'),
		'scope' => $request->get('scope'),
		'description' => $request->get('description'),
		'dir' => $request->get('dir'),
		'orientation' => $request->get('orientation'),
		'display' => $request->get('display'),
		'start_url' => $request->get('start_url'),
		'icons' => $request->get('icons'),
		]);
    }
}
