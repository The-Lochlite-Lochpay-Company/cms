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
use Lochlite\cms\Models\Services; 

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class ServicesController extends Controller
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
        $services = Services::paginate(15);
		if (request()->wantsJson()) {
           return $services;
         }
         return Lochlitecms::renderPanelCMS('services/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gerenciar Serviços | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gerenciar Serviços',
             'breadcrumbCurrentSection' => 'Plugins & Serviços',
             'services' => $services,
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
         return Lochlitecms::renderPanelCMS('services/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Criar Services | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Criar Services',
             'breadcrumbCurrentSection' => 'Aparência',
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
         'name' => 'string|required',
         'host' => 'string|required',
         'callback' => 'string|required',
         'query' => 'string|nullable',
         'type' => 'string|required',
         'datatype' => 'string|required',
         'items' => 'array|required',
         'status' => 'string|nullable',
        ]);
        Services::create([
         'domain' => $request->get('domain'),
         'name' => $request->get('name'),
         'host' => $request->get('host'),
         'callback' => $request->get('callback'),
         'query' => $request->get('query'),
         'type' => $request->get('type'),
         'data' => $request->get('datatype'),
         'api' => $request->input('items'),
         'status' => $request->get('status'),
	     ]);
        session()->flash('flash.banner', 'Um novo serviço foi registrado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
		return redirect()->route('managerservices.index');
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
         $service = Services::where('id', $id)->first();
         return Lochlitecms::renderPanelCMS('services/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Criar Services | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Criar Services',
             'breadcrumbCurrentSection' => 'Aparência',
             'service' => $service,
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
        $service = Services::where('id', $id)->first();
        request()->validate([
         'domain' => 'string|required',
         'name' => 'string|required',
         'host' => 'string|required',
         'callback' => 'string|required',
         'query' => 'string|nullable',
         'type' => 'string|required',
         'datatype' => 'string|required',
         'items' => 'array|required',
         'status' => 'string|nullable',
        ]);
        $service->update([
         'domain' => $request->get('domain'),
         'name' => $request->get('name'),
         'host' => $request->get('host'),
         'callback' => $request->get('callback'),
         'query' => $request->get('query'),
         'type' => $request->get('type'),
         'data' => $request->get('datatype'),
         'api' => $request->input('items'),
         'status' => $request->get('status'),
	     ]);
        session()->flash('flash.banner', 'O serviço selecionado foi atualizado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
		return redirect()->route('managerservices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $services = Services::where('id', $id)->first();
		$services->delete();
        session()->flash('flash.banner', 'O serviço selecionado foi excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
		return redirect()->route('managerservices.index');
    }
}
