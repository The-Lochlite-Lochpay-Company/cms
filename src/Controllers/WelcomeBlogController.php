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

namespace Lochlite\cms\Controllers;

use Illuminate\Http\Request;
use Lochlite\cms\Models\User;
use Lochlite\cms\Models\Posts;
use Lochlite\cms\Models\Postsbody;
use Lochlite\cms\Models\Postvoters;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Response; use Cache; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class WelcomeBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::orderBy('created_at', 'desc')->paginate(9);
		if (request()->wantsJson()) {
           return $posts;
        }
        return Lochlitecms::render('Web/posts', ['posts' => $posts], 'lochlitecms::tailwind');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendcomment(Request $request, $id)
    {
        request()->validate([
            'comment' => 'string|required|min:1|max:255',
        ]);
        try{
		if(Posts::where('id', $id)->exists()){	
        $post = Posts::where('id', $id)->first();
        $post->commented($request->get('comment'));
        session()->flash('flash.banner', 'O seu comentário foi enviado para moderação e poderá ser publicado em breve.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Comment received successfully');
        } else {
        session()->flash('flash.banner', 'Artigo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Article not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o seu comentário não foi registrado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to post comment')->setStatusCode(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try{
		if(Posts::where('url', $id)->orWhere('id', $id)->exists()){	
        $post = Posts::where('url', $id)->orWhere('id', $id)->first();
        $postbody = postsbody::where('post_id', $post->id)->first();
		$posted = $post->created_at->diffForHumans();
        $likes = $post->voters->where('type', 'upvote')->pluck('id');
        $deslikes = $post->voters->where('type', 'downnvote')->pluck('id');
        $comments = $post->commentsApproved();
        $voted = Auth()->check() == true ? $post->voters()->where('user_id', Auth()->User()->id)->exists() : true;
		 if(session()->has('views')){
		 if(collect(session()->get('views'))->where('id', $post->id)->count() == 0){
			session()->push('views', ['id' => $post->id]);
			$post->update(['views' => intval($post->views) + 1]);
		 }
		 } else {
			session()->put('views', array());
			session()->push('views', ['id' => $post->id]);
			$post->update(['views' => intval($post->views) + 1]);
		 }	
        return Inertia::render('Components/postrendering', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => $post->title ?? 'Sem titulo',
             'breadcrumbCurrentTitle' => 'Gestão de artigos',
             'breadcrumbCurrentSection' => 'Artigos',
             'user' => Auth()->check() == true ? Auth()->User() : null,
             'post' => $post,
             'postbody' => $postbody,
             'posted' => $posted,
             'comments' => $comments,
             'likes' => $likes,
             'deslikes' => $deslikes,
             'voted' => $voted,
             'version' => '2.0.5',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendvotes(Request $request, $id)
    {
        request()->validate([
            'type' => 'string|required|min:1|max:255',
        ]);
        try{
		if(Posts::where('id', $id)->exists()){	
        $post = Posts::where('id', $id)->first();
		     if(!$post->voters()->where('user_id', Auth()->User()->id)->exists()){
             $postvoters = Postvoters::create([
                 'post_id' => $post->id,
                 'user_id' => Auth()->User()->id,
                 'name' => Auth()->User()->name,
                 'avatar' => Auth()->User()->avatar,
                 'vote' => $request->get('type'),
		     ]);
		     if($request->get('type') == 'upvote'){	
              $post->update(['upvote' => intval($post->upvote) + 1]);
             } else {	
              $post->update(['downvote' => intval($post->upvote) + 1]);
             }
             session()->flash('flash.banner', 'O seu voto foi registrado com sucesso.');
             session()->flash('flash.bannerStyle', 'success');    
             return redirect()->back()->with('success','Vote received successfully');
             } else {
             session()->flash('flash.banner', 'Você já votou, só é permitido um voto por artigo!');
             session()->flash('flash.bannerStyle', 'danger');    
             return redirect()->back()->with('success','Only one vote per article is allowed!');
             }
        } else {
        session()->flash('flash.banner', 'Artigo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Article not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o seu voto não foi registrado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Vote registration failure')->setStatusCode(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
