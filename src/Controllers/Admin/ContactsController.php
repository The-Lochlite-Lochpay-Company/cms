<?php
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.8  
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
use Lochlite\cms\Models\Contacts;
use Lochlite\cms\Models\User;

use Lochlite\cms\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class ContactsController extends \App\Http\Controllers\Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {

        return [
            // examples with aliases, pipe-separated names, guards, etc:
            'auth',
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('publish system|edit system|delete system|publish ombudsman|edit ombudsman|delete ombudsman,sanctum'), only:['index', 'show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('publish system|publish ombudsman'), only:['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('edit system|edit ombudsman'), only:['edit','update','cleandata']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete system|delete ombudsman'), only:['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contacts::latest()->paginate(15);
		 if (request()->wantsJson()) {
           return $contacts;
         }
         return Lochlitecms::renderPanelCMS('contacts/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de chamados | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de chamados',
             'breadcrumbCurrentSection' => 'Contatos',
             'contacts' => $contacts,
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
         return Lochlitecms::renderPanelCMS('contacts/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de chamados | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de chamados',
             'breadcrumbCurrentSection' => 'Contatos',
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
            'name' => 'string|required',
            'email' => 'string|required',
            'status' => 'string|required',
            'message' => 'string|required',
        ]);
        try{
        $contact = Contacts::create([
            'visitor' => request()->getClientIp(),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'status' => $request->get('status'),
            'message' => $request->get('message'),
		]);

        session()->flash('flash.banner', 'Mensagem salva com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Message created successfully.');
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, a mensagem não foi salva!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Message has not been registered')->setStatusCode(500);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
		if(Contacts::where('id', $id)->exists()){	
        $contact = Contacts::find($id);
         return Lochlitecms::renderPanelCMS('contacts/show', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de chamados | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de chamados',
             'breadcrumbCurrentSection' => 'Contatos',
             'contact' => $contact,
             'version' => Lochlitecms::application()->get('version'),
         ]);
        } else {
        session()->flash('flash.banner', 'Mensagem não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Message not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados da mensagem!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve message data')->setStatusCode(500);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
		if(Contacts::where('id', $id)->exists()){	
        $contact = Contacts::find($id);
    
         return Lochlitecms::renderPanelCMS('contacts/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de chamados | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de chamados',
             'breadcrumbCurrentSection' => 'Contatos',
             'contact' => $contact,
             'version' => Lochlitecms::application()->get('version'),
         ]);
        } else {
        session()->flash('flash.banner', 'Mensagem não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Message not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados da mensagem!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve message data')->setStatusCode(500);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'string|required',
            'email' => 'string|required',
            'message' => 'string|required',
            'status' => 'string|required',
        ]);
        try{
		if(Contacts::where('id', $id)->exists()){	
        $contact = Contacts::find($id);
        $contact->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'message' => $request->get('message'),
            'status' => $request->get('status'),
		]);

        session()->flash('flash.banner', 'Mensagem atualizada com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Message updated successfully');
        } else {
        session()->flash('flash.banner', 'Mensagem não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Message has not been updated');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, a mensagem não foi atualizada!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Message has not been updated')->setStatusCode(500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
		if(Contacts::where('id', $id)->exists()){	
        Contacts::find($id)->delete();
		
        session()->flash('flash.banner', 'Mensagem excluida com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Message deleted successfully');
        } else {
        session()->flash('flash.banner', 'Mensagem não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Message has not been deleted');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, a mensagem não foi excluida!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Message has not been deleted')->setStatusCode(500);
        }
    }
}
