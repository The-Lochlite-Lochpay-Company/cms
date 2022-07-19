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
use Lochlite\cms\Models\Routes;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class RoutesController extends Controller
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
        $routes = Routes::paginate(20);
		 if (request()->wantsJson()) {
           return $routes;
         }
         return Lochlitecms::renderPanelCMS('routes/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gerenciamento de rotas | Lochlite CMS',
             'user' => Auth::User(),
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gerenciamento de rotas',
             'breadcrumbCurrentSection' => 'Rotas',
             'routes' => $routes,
             'version' => Lochlitecms::application()->get('version'),
         ]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetroutes()
    {
		 Routes::query()->truncate();
		 cache()->forget('routes');
         $addsystemroutes = Lochlitecms::defaultRoutes();
         $getallroutes = Lochlitecms::getRoutes();
		 session()->flash('flash.banner', 'As rotas foram resetadas com sucesso.');
         session()->flash('flash.bannerStyle', 'success');    
         return redirect()->route('managerroutes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return Lochlitecms::renderPanelCMS('routes/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Criar rota | Lochlite CMS',
             'user' => Auth::User(),
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Criar rota',
             'breadcrumbCurrentSection' => 'Rotas',
             'currentdomain' => request()->getSchemeAndHttpHost(),
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
         Routes::create([
		 'name' => $request->get('name'),
		 'url' => $request->get('url'),
		 'type' => $request->input('type'),
		 'action' => $request->get('action'),
		 'controller' => $request->get('controller'),
		 'status' => $request->get('status'),
		 'only' => $request->input('only'),
		 'except' => $request->input('except'),
		 'middleware' => $request->input('middleware'),
		 ]);
		 return redirect()->route('managerroutes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         if(Routes::where('id', $id)->exists()){
 		 $routes = Routes::where('id', $id)->first();
         return Lochlitecms::renderPanelCMS('routes/show', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gerenciamento de rotas | Lochlite CMS',
             'user' => Auth::User(),
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gerenciamento de rotas',
             'breadcrumbCurrentSection' => 'Rotas',
             'showroute' => $routes,
             'version' => Lochlitecms::application()->get('version'),
         ]);
		 }
		 return redirect()->route('managerroutes.index'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if(Routes::where('id', $id)->exists()){
 		 $routes = Routes::where('id', $id)->first();
         return Lochlitecms::renderPanelCMS('routes/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gerenciamento de rotas | Lochlite CMS',
             'user' => Auth::User(),
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gerenciamento de rotas',
             'breadcrumbCurrentSection' => 'Rotas',
             'showroute' => $routes,
             'currentdomain' => request()->getSchemeAndHttpHost(),
             'version' => Lochlitecms::application()->get('version'),
         ]);
		 }
		 return redirect()->route('managerroutes.index');
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
            'name' => 'string|required',
            'type' => 'required',
            'url' => 'string|required',
            'controller' => 'string|required',
            'status' => 'string|required',
            'action' => 'string|required',
            'only' => 'nullable',
            'except' => 'nullable',
            'middleware' => 'required',
        ]);
         if(Routes::where('id', $id)->exists()){
 		 $routes = Routes::where('id', $id)->first();
         $routes->update([
		 'name' => $request->get('name'),
		 'url' => $request->get('url'),
		 'type' => $request->input('type'),
		 'action' => $request->get('action'),
		 'controller' => $request->get('controller'),
		 'status' => $request->get('status'),
		 'only' => $request->input('only'),
		 'except' => $request->input('except'),
		 'middleware' => $request->input('middleware'),
		 ]);
		 }
		 return redirect()->route('managerroutes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		 if(Routes::where('id', $id)->exists()){
         $route = Routes::where('id', $id)->first();
		 $route->delete();
         }
		 return redirect()>back();
    }
}
