<?php
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.9  
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
use Lochlite\cms\Models\Pages;
use Lochlite\cms\Models\Routes;
use Lochlite\cms\Models\Comments;
use Lochlite\cms\Models\Emails;
use Lochlite\cms\Models\User;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		 if(!$request->query('inlinesearch') == true){
         return Lochlitecms::renderPanelCMS('search/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Search | Lochlite CMS',
             'user' => Auth::User(),
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Search',
             'breadcrumbCurrentSection' => 'Search',
             'version' => Lochlitecms::application()->get('version'),
         ]);
		 } else {
		 $type = $request->query('type');
		 $query = $request->query('query');
		 if($type == 'posts'){
			 $search = Posts::where('id', $query)->orWhere('title', 'like', '%'.  $query .'%')->orWhere('description', 'like', '%'.  $query .'%')->orWhere('category', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'pages'){
			 $search = Pages::where('id', $query)->orWhere('title', 'like', '%'.  $query .'%')->orWhere('description', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'comments'){
			 $search = Comments::where('id', $query)->orWhere('name', 'like', '%'.  $query .'%')->orWhere('email', 'like', '%'.  $query .'%')->orWhere('comment', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'routes'){
			 $search = Routes::where('id', $query)->orWhere('name', 'like', '%'.  $query .'%')->orWhere('url', 'like', '%'.  $query .'%')->orWhere('controller', 'like', '%'.  $query .'%')->orWhere('middleware', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'emails'){
			 $search = Emails::where('id', $query)->orWhere('to', 'like', '%'.  $query .'%')->orWhere('subject', 'like', '%'.  $query .'%')->orWhere('body', 'like', '%'.  $query .'%')->orWhere('from', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'users'){
			 $search = User::where('id', $query)->orWhere('name', 'like', '%'.  $query .'%')->orWhere('email', 'like', '%'.  $query .'%')->orWhere('phone', 'like', '%'.  $query .'%')->paginate();
		 }
         return Lochlitecms::renderPanelCMS('search/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Search | Lochlite CMS',
             'user' => Auth::User(),
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Search',
             'breadcrumbCurrentSection' => 'Search',
             'type' => $request->get('type'),
             'query' => $request->get('query'),
             'search' => $search,
             'version' => Lochlitecms::application()->get('version'),
         ]);			 
		 }
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
    public function store(Request $request)
    {
		 $type = $request->get('type');
		 $query = $request->get('query');
		 if($type == 'posts'){
			 $search = Posts::where('id', $query)->orWhere('title', 'like', '%'.  $query .'%')->orWhere('description', 'like', '%'.  $query .'%')->orWhere('category', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'pages'){
			 $search = Pages::where('id', $query)->orWhere('title', 'like', '%'.  $query .'%')->orWhere('description', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'comments'){
			 $search = Comments::where('id', $query)->orWhere('name', 'like', '%'.  $query .'%')->orWhere('email', 'like', '%'.  $query .'%')->orWhere('comment', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'routes'){
			 $search = Routes::where('id', $query)->orWhere('name', 'like', '%'.  $query .'%')->orWhere('url', 'like', '%'.  $query .'%')->orWhere('controller', 'like', '%'.  $query .'%')->orWhere('middleware', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'emails'){
			 $search = Emails::where('id', $query)->orWhere('to', 'like', '%'.  $query .'%')->orWhere('subject', 'like', '%'.  $query .'%')->orWhere('body', 'like', '%'.  $query .'%')->orWhere('from', 'like', '%'.  $query .'%')->paginate();
		 }
		 else if($type == 'users'){
			 $search = User::where('id', $query)->orWhere('name', 'like', '%'.  $query .'%')->orWhere('email', 'like', '%'.  $query .'%')->orWhere('phone', 'like', '%'.  $query .'%')->paginate();
		 }
         return Lochlitecms::renderPanelCMS('search/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Search | Lochlite CMS',
             'user' => Auth::User(),
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Search',
             'breadcrumbCurrentSection' => 'Search',
             'type' => $request->get('type'),
             'query' => $request->get('query'),
             'search' => $search,
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
