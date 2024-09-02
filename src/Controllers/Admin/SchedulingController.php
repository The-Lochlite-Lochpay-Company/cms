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
use Lochlite\cms\Models\Scheduling;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class SchedulingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish schedulings|edit schedulings|delete schedulings', ['only' => ['index','show']]);
         $this->middleware('permission:publish schedulings', ['only' => ['create','store']]);
         $this->middleware('permission:edit schedulings', ['only' => ['edit','update']]);
         $this->middleware('permission:delete schedulings', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		 if ($request->wantsJson()) {
		     $listevents = Scheduling::whereDate('start', '>=', $request->query('start') ?? now()->subDays(31))->whereDate('end', '<=', $request->query('end') ?? now())->get();
             return response()->json($listevents);
         }
         return Lochlitecms::renderPanelCMS('scheduling/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de agendamentos | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de agendamentos',
             'breadcrumbCurrentSection' => 'Agendamentos',
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
        $request->validate([
            'title' => 'string|required',
            'start' => 'string|required',
            'end' => 'string|required',
        ]);
        $event = Scheduling::create([
             'user_id' => '',
             'user_name' => '',
             'description' => '',
             'title' => $request->get('title'),
             'start' => $request->get('start'),
             'end' => $request->get('end'),
        ]);
        session()->flash('flash.banner', 'Evento salvo com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
         return Lochlitecms::renderPanelCMS('scheduling/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de agendamentos | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de agendamentos',
             'breadcrumbCurrentSection' => 'Agendamentos',
             'version' => Lochlitecms::application()->get('version'),
			 'id' => $event->id
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string|required',
            'start' => 'string|required',
            'end' => 'string|required',
        ]);
        $event = Scheduling::where('id', $id)->first()->update([
             'title' => $request->get('title'),
             'start' => now()->parse($request->get('start')),
             'end' => now()->parse($request->get('end')),
        ]);
        session()->flash('flash.banner', 'Evento atualizado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Event updated successfully');


	}
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try{
		if(Scheduling::where('id', $id)->exists()){	
        Scheduling::where('id', $id)->delete();

        session()->flash('flash.banner', 'Evento excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Event deleted successfully');
        } else {
        session()->flash('flash.banner', 'Evento não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('erro','Event has not been deleted');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o evento não foi excluido!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Event has not been deleted');
        }

	}
}
