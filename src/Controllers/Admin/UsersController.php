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
use lochlite\cms\Models\User;

use lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish users|edit users|delete users', ['only' => ['index','show']]);
         $this->middleware('permission:publish users', ['only' => ['create','store']]);
         $this->middleware('permission:edit users', ['only' => ['edit','update']]);
         $this->middleware('permission:delete users', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $users = User::orderBy('id','DESC')->paginate(15);
		 if (request()->wantsJson()) {
           return $users;
         }
         return Inertia::render('Panel/users/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de usuários | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de usuários',
             'breadcrumbCurrentSection' => 'Usuários',
             'users' => $users,
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
        $roles = Role::all();
         return Inertia::render('Panel/users/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de usuários | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de usuários',
             'breadcrumbCurrentSection' => 'Usuários',
             'roles' => $roles,
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
        $this->validate($request, [
            'name' => 'string|required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required'
        ]);
        try{
        $newuser = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),		
		]);
        $newuser->assignRole($request->input('roles'));

        session()->flash('flash.banner', 'Usuário criado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','User created successfully.');
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o usuário não foi criado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','User has not been registered')->setStatusCode(500);
        }
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
		if(User::where('id', $id)->exists()){	
         $user = User::find($id);
         return Inertia::render('Panel/users/show', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de usuários | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de usuários',
             'breadcrumbCurrentSection' => 'Usuários',
             'userid' => $user->id,
             'useravatar' => $user->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'username' => $user->name ?? 'User Name',
             'useremail' => $user->email ?? 'undefined',
             'userroles' => $user->getRoleNames(),
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
        } else {
        session()->flash('flash.banner', 'Usuário não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','User not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do usuário!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve user data')->setStatusCode(500);
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
        try{
		if(User::where('id', $id)->exists()){	
        $user = User::find($id);
        $roles = Role::all();
        $userroles = $user->getRoleNames(); 
    
         return Inertia::render('Panel/users/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de usuários | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de usuários',
             'breadcrumbCurrentSection' => 'Usuários',
             'userid' => $user->id,
             'useravatar' => $user->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'username' => $user->name ?? 'User Name',
             'useremail' => $user->email ?? 'undefined',
             'rolesall' => $roles,
             'userroles' => $user->getRoleNames(),
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
        } else {
        session()->flash('flash.banner', 'Usuário não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','User not found');
        }
		} catch(\Exception $e){dd($e);
        session()->flash('flash.banner', 'Falha ao recuperar os dados do usuário!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve user data')->setStatusCode(500);
        }
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
            'name' => 'string|nullable',
            'email' => 'string|nullable|email|unique:users,email,'.$id,
            'password' => 'same:password_confirmation',
            'roles' => 'required'
        ]);
        try{
		if(User::where('id', $id)->exists()){	
        $input = $request->all();
        if(!empty($input['password'])){$input['password'] = Hash::make($input['password']);}else{$input = Arr::except($input,array('password'));}
        if(empty($input['name'])){$input = Arr::except($input,array('name'));}
        if(empty($input['email'])){$input = Arr::except($input,array('email'));}
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));

        session()->flash('flash.banner', 'Usuário atualizado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','User updated successfully');
        } else {
        session()->flash('flash.banner', 'Usuário não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','User has not been updated');
        }
		} catch(\Exception $e){dd($e);
        session()->flash('flash.banner', 'Ocorreu um erro, o usuário não foi atualizado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','User has not been updated')->setStatusCode(500);
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
        try{
		if(User::where('id', $id)->exists()){	
        User::find($id)->delete();
		
        session()->flash('flash.banner', 'Usuário excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','User deleted successfully');
        } else {
        session()->flash('flash.banner', 'Usuário não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','User has not been deleted');
        }
		} catch(\Exception $e){dd($e);
        session()->flash('flash.banner', 'Ocorreu um erro, o usuário não foi excluido!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','User has not been deleted')->setStatusCode(500);
        }
    }
}
