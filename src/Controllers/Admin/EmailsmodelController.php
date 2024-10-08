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
use Spatie\MailTemplates\Models\MailTemplate;

use Lochlite\cms\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class EmailsmodelController extends \App\Http\Controllers\Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {

        return [
            // examples with aliases, pipe-separated names, guards, etc:
            'auth',
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('publish system|edit system|delete system|publish articles|edit articles|delete articles,sanctum'), only:['index', 'show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('publish system|publish articles'), only:['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('edit system|edit articles'), only:['edit','update','cleandata']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete system|delete articles'), only:['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = MailTemplate::paginate(15);
		 if (request()->wantsJson()) {
           return $emails;
         }
         return Lochlitecms::renderPanelCMS('emails/models', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de emails | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de emails',
             'breadcrumbCurrentSection' => 'Emails',
             'emails' => $emails,
             'version' => Lochlitecms::application()->get('version'),
         ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $model = MailTemplate::find($id);
         return Lochlitecms::renderPanelCMS('emails/showmodel', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de emails | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de emails',
             'breadcrumbCurrentSection' => 'Emails',
             'model' => $model,
             'modelbody' => base64_encode($model->html_template),
             'version' => Lochlitecms::application()->get('version'),
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $model = MailTemplate::find($id);
         return Lochlitecms::renderPanelCMS('emails/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de emails | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de emails',
             'breadcrumbCurrentSection' => 'Emails',
             'model' => $model,
             'modelbody' => base64_encode($model->html_template),
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
             'subject' => 'string|required',
             'body' => 'string|required',
         ]);
         try{
		 if(MailTemplate::where('id', $id)->exists()){	
         $model = MailTemplate::find($id);
		 $model->update(['subject' => $request->get('subject'), 'html_template' => $request->get('body')]);
         session()->flash('flash.banner', 'Modelo de email atualizado com sucesso.');
         session()->flash('flash.bannerStyle', 'success');    
         return redirect()->back()->with('success','Model updated successfully');
         } else {
         session()->flash('flash.banner', 'Modelo não encontrado.');
         session()->flash('flash.bannerStyle', 'danger');    
         return redirect()->back()->with('success','Model has not been updated');
         }
		 } catch(\Exception $e){
         session()->flash('flash.banner', 'Ocorreu um erro, o modelo de email não foi atualizado!');
         session()->flash('flash.bannerStyle', 'danger');    
         return redirect()->back()->with('error','Model has not been updated')->setStatusCode(500);
         }
    }
}
