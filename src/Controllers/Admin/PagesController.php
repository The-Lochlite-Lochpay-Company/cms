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
use Lochlite\cms\Models\Pages;
use Lochlite\cms\Models\Pagesbody;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish pages|edit pages|delete pages', ['only' => ['index','show']]);
         $this->middleware('permission:publish pages', ['only' => ['create','store']]);
         $this->middleware('permission:edit pages', ['only' => ['edit','update']]);
         $this->middleware('permission:delete pages', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Pages::latest()->paginate(15);
		 if (request()->wantsJson()) {
           return $pages;
         }
         return Lochlitecms::renderPanelCMS('Panel/pages/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de pagínas | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de pagínas',
             'breadcrumbCurrentSection' => 'Pagínas',
             'pages' => $pages,
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
         return Lochlitecms::renderPanelCMS('Panel/pages/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de pagínas | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de pagínas',
             'breadcrumbCurrentSection' => 'Pagínas',
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
            'title' => 'string|required',
            'description' => 'string|required',
            'keywords' => 'string|nullable',
            'welcome' => 'string|nullable',
            'body' => 'string|required',
        ]);
        try{
   
        $page = Pages::create([
            'authors' => Auth()->User()->name,
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'welcome' => $request->get('welcome'),
		]);
        $pagebody = Pagesbody::create([
            'page_id' => $page->id,
            'body' => $request->get('body'),
		]);
    
        session()->flash('flash.banner', 'Pagína criada com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Page created successfully.');
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, a pagína não foi criada!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Page has not been registered')->setStatusCode(500);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $pages
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
		if(Pages::where('id', $id)->exists()){	
         $page = Pages::find($id);
         return Lochlitecms::renderPanelCMS('Panel/pages/show', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de pagínas | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de pagínas',
             'breadcrumbCurrentSection' => 'Pagínas',
             'page' => $page,
             'version' => Lochlitecms::application()->get('version'),
         ]);
        } else {
        session()->flash('flash.banner', 'Pagína não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Page not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados da pagína!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve pagína data')->setStatusCode(500);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $pages
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
		if(Pages::where('id', $id)->exists()){	
        $page = Pages::find($id);
        $pagebody = Pagesbody::where('page_id', $page->id)->first();

         return Lochlitecms::renderPanelCMS('Panel/pages/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de pagínas | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de pagínas',
             'breadcrumbCurrentSection' => 'Pagínas',
             'page' => $page,
             'pagebody' => $pagebody,
             'version' => Lochlitecms::application()->get('version'),
         ]);
        } else {
        session()->flash('flash.banner', 'Pagína não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Page not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados da pagína!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve page data')->setStatusCode(500);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $pages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'keywords' => 'string|nullable',
            'welcome' => 'integer|nullable',
            'body' => 'string|required',
        ]);
        try{
		if(Pages::where('id', $id)->exists()){	
        $page = Pages::find($id);
        $page->update([
            'title' => $request->get('title') ?? $page->title,
            'description' => $request->get('description') ?? $page->description,
            'keywords' => $request->get('keywords') ?? $page->keywords,
            'welcome' => $request->get('welcome'),
		]);
        $page->body()->update([
            'body' => $request->get('body'),
		]);
    
        session()->flash('flash.banner', 'Pagína atualizada com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Page updated successfully');
        } else {
        session()->flash('flash.banner', 'Pagína não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Page has not been updated');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, a pagína não foi atualizada!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Page has not been updated')->setStatusCode(500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
		if(Pages::where('id', $id)->exists()){	
        Pages::find($id)->delete();
		
        session()->flash('flash.banner', 'Pagína excluida com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Page deleted successfully');
        } else {
        session()->flash('flash.banner', 'Pagína não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Page has not been deleted');
        }
		} catch(\Exception $e){dd($e); 
        session()->flash('flash.banner', 'Ocorreu um erro, a pagína não foi excluida!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Page has not been deleted')->setStatusCode(500);
        }
    }
}
