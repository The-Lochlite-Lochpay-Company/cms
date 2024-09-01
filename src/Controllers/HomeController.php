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
use Lochlite\cms\Models\Customersarea; 
use Lochlite\cms\Models\Posts;
use Lochlite\cms\Models\Comments;
use Lochlite\cms\Models\Notifications;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Carbon\Carbon; use Inertia\Inertia; use Response; use Cache; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;
use Lochlitecms;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user = Auth()->User();
		$customersarea = Customersarea::where('domain', request()->getHttpHost())->orWhere('default', 1)->first();
		$posts = Posts::latest()->limit(3)->get();
		return Lochlitecms::renderAuth('vendor/lochlite/cms/src/Views/Customersarea/dashboard', [
		'title' => "Customer's area",
		'customersarea' => $customersarea,
		'posts' => $posts,
		], 'lochlitecms::tailwind');
    }

    public function comments()
    {
		$user = Auth()->User();
		$customersarea = Customersarea::where('domain', request()->getHttpHost())->orWhere('default', 1)->first();
		$comments = Comments::where('user_id', $user->id)->paginate();
		return Lochlitecms::renderAuth('vendor/lochlite/cms/src/Views/Customersarea/comments', [
		'title' => "Customer's area",
		'customersarea' => $customersarea,
		'comments' => $comments,
		], 'lochlitecms::tailwind');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notifications(Request $request)
    {
		$user = Auth()->User();
		$customersarea = Customersarea::where('domain', request()->getHttpHost())->orWhere('default', 1)->first();
		$notifications = Notifications::where('user_id', null)->paginate();
		return Lochlitecms::renderAuth('vendor/lochlite/cms/src/Views/Customersarea/notifications', [
		'title' => "Customer's area",
		'tab' => $request->query('tab'),
		'customersarea' => $customersarea,
		'notifications' => $notifications,
		], 'lochlitecms::tailwind');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
		$user = Auth()->User();
		$customersarea = Customersarea::where('domain', request()->getHttpHost())->orWhere('default', 1)->first();
		$history = Lochlitecms::getHistory($user->id);
		return Lochlitecms::renderAuth('vendor/lochlite/cms/src/Views/Customersarea/history', [
		'title' => "History",
		'customersarea' => $customersarea,
		'history' => $history,
		], 'lochlitecms::tailwind');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
		$customersarea = Customersarea::where('domain', request()->getHttpHost())->orWhere('default', 1)->first();
		return Lochlitecms::renderAuth('vendor/lochlite/cms/src/Views/Customersarea/profile', [
		'title' => "Profile",
		'customersarea' => $customersarea,
		'user' => Auth()->User(),
		], 'lochlitecms::tailwind');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editprofile(Request $request)
    {
		$customersarea = Customersarea::where('domain', request()->getHttpHost())->orWhere('default', 1)->first();
		return Lochlitecms::renderAuth('vendor/lochlite/cms/src/Views/Customersarea/editprofile', [
		'title' => "Edit Profile",
		'customersarea' => $customersarea,
		'user' => Auth()->User(),
		'tab' => $request->query('tab'),
		], 'lochlitecms::tailwind');
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
        $this->validate($request, [
            'file' => 'required|mimes:png,jpg,jpeg,webp,gif,ico|max:2048',
        ]);
		return Lochlitecms::setAvatar($request);
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
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'gender' => 'string|nullable',
            'email' => 'string|required|email|unique:users,email,'.Auth()->User()->id,
            'phone' => 'numeric|nullable',
            'social_security' => 'numeric|nullable',
            'address' => 'string|nullable',
            'address_number' => 'numeric|nullable',
            'city' => 'string|nullable',
            'state' => 'string|nullable',
            'coutry' => 'string|nullable',
            'zipcode' => 'string|nullable',
            'password' => 'same:confirmpassword',
        ]);
        try{
        $user = Auth()->User();
        $user->update([
		'name' => $request->get('first_name') ?? Auth()->User()->name,
		'last_name' => $request->get('last_name') ?? Auth()->User()->last_name,
		'gender' => $request->get('gender') ?? Auth()->User()->gender,
		'email' => $request->get('email') ?? Auth()->User()->email,
		'phone' => $request->get('phone') ?? Auth()->User()->phone,
		'social_security' => $request->get('social_security') ?? Auth()->User()->social_security,
		'address' => $request->get('address') ?? Auth()->User()->address,
		'address_number' => $request->get('address_number') ?? Auth()->User()->address_number,
		'city' => $request->get('city') ?? Auth()->User()->city,
		'state' => $request->get('state') ?? Auth()->User()->state,
		'country' => $request->get('country') ?? Auth()->User()->country,
		'zipcode' => $request->get('zipcode') ?? Auth()->User()->zipcode,
		'password' => $request->get('password') === null ? Auth()->User()->password : Hash::make($request->get('password')),
		]);
        session()->flash('flash.banner', 'Os seus dados foram atualizados com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back();
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro ao atualizar o seu perfil, tente novamente mais tarde.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back();
        }
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
