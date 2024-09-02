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
use Lochlite\cms\Models\Login;
use Lochlite\cms\Models\Services;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $login = Login::paginate(15);
		if (request()->wantsJson()) {
           return $login;
         }
         return Lochlitecms::renderPanelCMS('login/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Login & Registro | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Login & Registro',
             'breadcrumbCurrentSection' => 'Aparência',
             'login' => $login,
             'version' => Lochlitecms::application()->get('version'),
         ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		 $services = Services::all();
         return Lochlitecms::renderPanelCMS('login/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Login & Registro | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Login & Registro',
             'breadcrumbCurrentSection' => 'Aparência',
             'services' => $services,
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
        Login::create([
		'domain' => $request->get('domain'),
		'default' => $request->get('default'),
		'image' => $request->get('image'),
		'imagevisible' => $request->get('imagevisible'),
		'logo' => $request->get('logo'),
		'emphasis' => $request->get('emphasis'),
		'title' => $request->get('title'),
		'description' => $request->get('description'),
		'forgottext' => $request->get('forgottext'),
		'buttontext' => $request->get('buttontext'),
		'buttoncolor' => $request->get('buttoncolor'),
		'buttontextcolor' => $request->get('buttontextcolor'),
		'google' => $request->get('google'),
		'googlereference' => $request->get('goprovider'),
		'facebook' => $request->get('facebook'),
		'facebookreference' => $request->get('fbprovider'),
		'twitter' => $request->get('twitter'),
		'twitterreference' => $request->get('ttprovider'),
		]);
		return redirect()->route('managerlogin.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		 $login = Login::where('id', $id)->first();
		 $services = Services::all();
         return Lochlitecms::renderPanelCMS('login/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Login & Registro | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Login & Registro',
             'breadcrumbCurrentSection' => 'Aparência',
             'services' => $services,
             'login' => $login,
             'version' => Lochlitecms::application()->get('version'),
         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$login = Login::where('id', $id)->first();
        $login->update([
		'domain' => $request->get('domain'),
		'default' => $request->get('default'),
		'image' => $request->get('image'),
		'imagevisible' => $request->get('imagevisible'),
		'logo' => $request->get('logo'),
		'emphasis' => $request->get('emphasis'),
		'title' => $request->get('title'),
		'description' => $request->get('description'),
		'forgottext' => $request->get('forgottext'),
		'buttontext' => $request->get('buttontext'),
		'buttoncolor' => $request->get('buttoncolor'),
		'buttontextcolor' => $request->get('buttontextcolor'),
		'google' => $request->get('google'),
		'googlereference' => $request->get('goprovider'),
		'facebook' => $request->get('facebook'),
		'facebookreference' => $request->get('fbprovider'),
		'twitter' => $request->get('twitter'),
		'twitterreference' => $request->get('ttprovider'),
		]);
		return redirect()->route('managerlogin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$login = Login::where('id', $id)->first();
		$login->delete();
    }
}
