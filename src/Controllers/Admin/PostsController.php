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

namespace lochlite\cms\Controllers\Admin;

use Illuminate\Http\Request;
use lochlite\cms\Models\Settings;
use lochlite\cms\Models\Posts;
use lochlite\cms\Models\Postsbody;
use Spatie\Sitemap\Sitemap;

use lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish articles|edit articles|delete articles', ['only' => ['index','show']]);
         $this->middleware('permission:publish articles', ['only' => ['create','store']]);
         $this->middleware('permission:edit articles', ['only' => ['edit','update']]);
         $this->middleware('permission:delete articles', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::latest()->paginate(15);
		 if (request()->wantsJson()) {
           return $posts;
         }
         return Inertia::render('Panel/posts/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de artigos | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de artigos',
             'breadcrumbCurrentSection' => 'Artigos',
             'posts' => $posts,
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return Inertia::render('Panel/posts/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de artigos | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de artigos',
             'breadcrumbCurrentSection' => 'Artigos',
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
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
            'title' => 'string|required|unique:posts,title',
            'description' => 'string|required',
            'keywords' => 'string|nullable',
            'image' => 'url|nullable',
            'body' => 'string|required',
        ]);
        try{
        $post = Posts::create([
            'authors' => Auth()->User()->name,
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'imgcap' => $request->get('image'),
		]);
         Postsbody::create([
            'post_id' => $post->id,
            'body' => $request->get('body'),
		]);
		try{
        //Sitemap::create()->add($post);
        session()->flash('flash.banner', 'Artigo criado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Article created successfully.');
		} catch(\Exception $e){
        session()->flash('flash.banner', 'O artigo foi criado com sucesso, mas não foi adicionado ao mapa do site.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to add item to sitemap');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o Artigo não foi criado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Article has not been registered')->setStatusCode(500);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $posts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
		if(Posts::where('id', $id)->exists()){	
        $post = Posts::find($id);
         return Inertia::render('Panel/posts/show', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de artigos | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de artigos',
             'breadcrumbCurrentSection' => 'Artigos',
             'post' => $post,
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
        } else {
        session()->flash('flash.banner', 'Artigo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Article not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do artigo!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve article data')->setStatusCode(500);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
		if(Posts::where('id', $id)->exists()){	
        $post = Posts::find($id);
        $postbody = Postsbody::where('post_id', $post->id)->first();
    
         return Inertia::render('Panel/posts/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de artigos | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de artigos',
             'breadcrumbCurrentSection' => 'Artigos',
             'post' => $post,
             'postbody' => $postbody,
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
        } else {
        session()->flash('flash.banner', 'Artigo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Article not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do artigo!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve article data')->setStatusCode(500);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'keywords' => 'string|nullable',
            'image' => 'url|nullable',
            'body' => 'string|required',
        ]);
        try{
		if(Posts::where('id', $id)->exists()){	
        $post = Posts::find($id);
        $post->update([
            'title' => $request->get('title') ?? $post->title,
            'description' => $request->get('description') ?? $post->description,
            'keywords' => $request->get('keywords') ?? $post->keywords,
            'imgcap' => $request->get('image') ?? $post->imgcap,
		]);
        $post->body()->update([
            'body' => $request->get('body'),
		]);

        session()->flash('flash.banner', 'Artigo atualizado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Article updated successfully');
        } else {
        session()->flash('flash.banner', 'Artigo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Article has not been updated');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, artigo não foi atualizado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Article has not been updated')->setStatusCode(500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
		if(Posts::where('id', $id)->exists()){	
        Posts::find($id)->delete();
		
        session()->flash('flash.banner', 'Artigo excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Article deleted successfully');
        } else {
        session()->flash('flash.banner', 'Artigo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Article has not been deleted');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o artigo não foi excluido!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Article has not been deleted')->setStatusCode(500);
        }
    }
}
