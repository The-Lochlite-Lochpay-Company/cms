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
use Lochlite\cms\Models\Posts;
use Lochlite\cms\Models\Comments;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish comments|edit comments|delete comments', ['only' => ['index','show']]);
         $this->middleware('permission:publish comments', ['only' => ['create','store']]);
         $this->middleware('permission:edit comments', ['only' => ['edit','update']]);
         $this->middleware('permission:delete comments', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comments::approved()->latest()->with('post')->paginate(15);
		if (request()->wantsJson()) {
           return $comments;
         }
         return Lochlitecms::renderPanelCMS('Panel/comments/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de comentários | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de comentários',
             'breadcrumbCurrentSection' => 'Comentários',
             'comments' => $comments,
             'version' => Lochlitecms::application()->get('version'),
         ]);
    }
 
    /**
     * Display a listing of the resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function moderate()
    {
        $comments = Comments::pending()->latest()->with('post')->paginate(15);
		if (request()->wantsJson()) {
           return $comments;
         }
         return Lochlitecms::renderPanelCMS('Panel/comments/moderate', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de comentários | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de comentários',
             'breadcrumbCurrentSection' => 'Comentários',
             'comments' => $comments,
             'version' => Lochlitecms::application()->get('version'),
         ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function moderatesetapproved(Request $request, $id)
    {
        request()->validate([
            'status' => 'string|nullable',
        ]);
        try{
		if(Comments::where('id', $id)->exists()){	
        $comment = Comments::find($id);
        $comment->update([
            'status' => $request->get('status') ?? $comment->status,
		]);

        session()->flash('flash.banner', 'Comentário atualizado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Comment updated successfully');
        } else {
        session()->flash('flash.banner', 'Comentário não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Comment has not been updated');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o comentário não foi atualizado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Comment has not been updated')->setStatusCode(500);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
		if(Comments::where('id', $id)->exists()){	
        $comment = Comments::where('id', $id)->with('post', 'reply')->first();
		return Lochlitecms::renderPanelCMS('Panel/comments/show', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de comentários | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de comentários',
             'breadcrumbCurrentSection' => 'Comentários',
             'comment' => $comment,
             'version' => Lochlitecms::application()->get('version'),
         ]);
        } else {
        session()->flash('flash.banner', 'Comentário não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Comment not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do comentário!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve comment data')->setStatusCode(500);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
		if(Comments::where('id', $id)->exists()){	
        $comment = Comments::where('id', $id)->first();
		return Lochlitecms::renderPanelCMS('Panel/comments/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de comentários | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de comentários',
             'breadcrumbCurrentSection' => 'Comentários',
             'comment' => $comment,
             'version' => Lochlitecms::application()->get('version'),
         ]);
        } else {
        session()->flash('flash.banner', 'Comentário não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Comment not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do comentário!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve comment data')->setStatusCode(500);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'string|required',
            'email' => 'string|nullable',
            'status' => 'string|nullable',
            'comment' => 'string|required',
        ]);
        try{
		if(Comments::where('id', $id)->exists()){	
        $comment = Comments::find($id);
        $comment->update([
            'name' => $request->get('name') ?? $comment->name,
            'email' => $request->get('email') ?? $comment->email,
            'status' => $request->get('status') ?? $comment->status,
            'comment' => $request->get('comment') ?? $comment->comment,
		]);

        session()->flash('flash.banner', 'Comentário atualizado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Comment updated successfully');
        } else {
        session()->flash('flash.banner', 'Comentário não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Comment has not been updated');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o comentário não foi atualizado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Comment has not been updated')->setStatusCode(500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
		if(Comments::where('id', $id)->exists()){	
        Comments::find($id)->delete();

        session()->flash('flash.banner', 'Comentário excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Comment deleted successfully');
        } else {
        session()->flash('flash.banner', 'Comentário não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Comment has not been deleted');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o comentário não foi excluido!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Comment has not been deleted')->setStatusCode(500);
        }
    }
}
