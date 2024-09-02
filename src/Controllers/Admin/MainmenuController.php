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
use Lochlite\cms\Models\Menu; 

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class MainmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish system|edit system|delete system', ['only' => ['index','show']]);
         $this->middleware('permission:publish system', ['only' => ['create','store']]);
         $this->middleware('permission:edit system', ['only' => ['edit','update','cleandata']]);
         $this->middleware('permission:delete system', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mainmenu = Menu::paginate(15);
		if (request()->wantsJson()) {
           return $mainmenu;
         }
         return Lochlitecms::renderPanelCMS('mainmenu/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gerenciar menu | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gerenciar menu',
             'breadcrumbCurrentSection' => 'Aparência',
             'mainmenu' => $mainmenu,
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
         return Lochlitecms::renderPanelCMS('mainmenu/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Criar menu | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Criar menu',
             'breadcrumbCurrentSection' => 'Aparência',
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
        request()->validate([
         'domain' => 'string|required',
         'menuclass' => 'string|required',
         'menuid' => 'string|required',
         'name' => 'string|required',
         'brand' => 'string|required',
         'brandtype' => 'string|required',
         'button1' => 'string|nullable',
         'button1id' => 'string|nullable',
         'button1class' => 'string|nullable',
         'button1route' => 'string|nullable',
         'button1status' => 'string|nullable',
         'button2' => 'string|nullable',
         'button2id' => 'string|nullable',
         'button2class' => 'string|nullable',
         'button2route' => 'string|nullable',
         'button2status' => 'string|nullable',
         'facebook' => 'string|nullable',
         'twitter' => 'string|nullable',
         'linkedin' => 'string|nullable',
         'pinterest' => 'string|nullable',
         'instagram' => 'string|nullable',
         'tiktok' => 'string|nullable',
         'whatsapp' => 'string|nullable',
         'youtube' => 'string|nullable',
         'search' => 'numeric|required',
         'searchroute' => 'string|required',
         'stickytop' => 'numeric|required',
         'itemscenter' => 'numeric|required',
         'type' => 'string|required',
         'default' => 'numeric|required',
         'status' => 'string|required',
        ]);
        Menu::create([
         'domain' => $request->get('domain'),
         'menuclass' => $request->get('menuclass'),
         'menuid' => $request->get('menuid'),
         'name' => $request->get('name'),
         'brand' =>  $request->get('brand'),
         'brandtype' => $request->get('brandtype'),
         'button1' => $request->get('button1'),
         'button1id' => $request->get('button1id'),
         'button1class' => $request->get('button1class'),
         'button1route' => $request->get('button1route'),
         'button1status' => $request->get('button1status'),
         'button2' => $request->get('button2'),
         'button2id' => $request->get('button2id'),
         'button2class' => $request->get('button2class'),
         'button2route' => $request->get('button2route'),
         'button2status' => $request->get('button2status'),
         'facebook' => $request->get('facebook'),
         'twitter' => $request->get('twitter'),
         'linkedin' => $request->get('linkedin'),
         'pinterest' => $request->get('pinterest'),
         'instagram' => $request->get('instagram'),
         'tiktok' => $request->get('tiktok'),
         'whatsapp' => $request->get('whatsapp'),
         'youtube' => $request->get('youtube'),
         'search' => $request->get('search'),
         'searchroute' => $request->get('searchroute'),
         'stickytop' => $request->get('stickytop'),
         'itemscenter' => $request->get('itemscenter'),
         'type' => $request->get('type'),
         'default' => $request->get('default'),
         'status' => $request->get('status'),
	     ]);
        session()->flash('flash.banner', 'Um novo menu foi registrado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
		return redirect()->route('managermainmenu.index');
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $mainmenu = Menu::where('id', $id)->first();
         return Lochlitecms::renderPanelCMS('mainmenu/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Criar menu | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Criar menu',
             'breadcrumbCurrentSection' => 'Aparência',
             'mainmenu' => $mainmenu,
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
        request()->validate([
         'domain' => 'string|required',
         'menuclass' => 'string|required',
         'menuid' => 'string|required',
         'name' => 'string|required',
         'brand' => 'string|required',
         'brandtype' => 'string|required',
         'button1' => 'string|nullable',
         'button1id' => 'string|nullable',
         'button1class' => 'string|nullable',
         'button1route' => 'string|nullable',
         'button1status' => 'string|nullable',
         'button2' => 'string|nullable',
         'button2id' => 'string|nullable',
         'button2class' => 'string|nullable',
         'button2route' => 'string|nullable',
         'button2status' => 'string|nullable',
         'facebook' => 'string|nullable',
         'twitter' => 'string|nullable',
         'linkedin' => 'string|nullable',
         'pinterest' => 'string|nullable',
         'instagram' => 'string|nullable',
         'tiktok' => 'string|nullable',
         'whatsapp' => 'string|nullable',
         'youtube' => 'string|nullable',
         'search' => 'numeric|required',
         'searchroute' => 'string|required',
         'stickytop' => 'numeric|required',
         'itemscenter' => 'numeric|required',
         'type' => 'string|required',
         'default' => 'numeric|required',
         'status' => 'string|required',
        ]);
        $mainmenu = Menu::where('id', $id)->first();
        $mainmenu->update([
         'domain' => $request->get('domain'),
         'menuclass' => $request->get('menuclass'),
         'menuid' => $request->get('menuid'),
         'name' => $request->get('name'),
         'brand' =>  $request->get('brand'),
         'brandtype' => $request->get('brandtype'),
         'button1' => $request->get('button1'),
         'button1id' => $request->get('button1id'),
         'button1class' => $request->get('button1class'),
         'button1route' => $request->get('button1route'),
         'button1status' => $request->get('button1status'),
         'button2' => $request->get('button2'),
         'button2id' => $request->get('button2id'),
         'button2class' => $request->get('button2class'),
         'button2route' => $request->get('button2route'),
         'button2status' => $request->get('button2status'),
         'facebook' => $request->get('facebook'),
         'twitter' => $request->get('twitter'),
         'linkedin' => $request->get('linkedin'),
         'pinterest' => $request->get('pinterest'),
         'instagram' => $request->get('instagram'),
         'tiktok' => $request->get('tiktok'),
         'whatsapp' => $request->get('whatsapp'),
         'youtube' => $request->get('youtube'),
         'search' => $request->get('search'),
         'searchroute' => $request->get('searchroute'),
         'stickytop' => $request->get('stickytop'),
         'itemscenter' => $request->get('itemscenter'),
         'type' => $request->get('type'),
         'default' => $request->get('default'),
         'status' => $request->get('status'),
	     ]);
        session()->flash('flash.banner', 'O menu selecionado foi atualizado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
		return redirect()->route('managermainmenu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mainmenu = Menu::where('id', $id)->first();
		$mainmenu->delete();
        session()->flash('flash.banner', 'O menu selecionado foi excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
		return redirect()->route('managermainmenu.index');
    }
}
