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
use lochlite\cms\Models\Feedbacks;
use lochlite\cms\Models\Feedbacksresponses;

use lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class FeedbacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('auth:sanctum');
         $this->middleware('permission:publish feedbacks|edit feedbacks|delete feedbacks', ['only' => ['index','show']]);
         $this->middleware('permission:publish feedbacks', ['only' => ['create','store']]);
         $this->middleware('permission:edit feedbacks', ['only' => ['edit','update']]);
         $this->middleware('permission:delete feedbacks', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = Feedbacks::latest()->get();
        $feedbacksresponses = Feedbacksresponses::latest()->paginate(15);
         return Inertia::render('Panel/feedbacks/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de feedbacks | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de feedbacks',
             'breadcrumbCurrentSection' => 'Feedbacks',
             'feedbacks' => $feedbacks,
             'feedbacksresponses' => $feedbacksresponses,
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
         return Inertia::render('Panel/feedbacks/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de feedbacks | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de feedbacks',
             'breadcrumbCurrentSection' => 'Feedbacks',
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
            'question' => 'string|required',
            'option1' => 'string|required',
            'option2' => 'string|required',
            'option3' => 'string|nullable',
            'option4' => 'string|nullable',
            'option5' => 'string|nullable',
        ]);
        try{
        $feedback = Feedbacks::create([
            'author' => Auth()->User()->name,
            'question' => $request->get('question'),
            'option1' => $request->get('option1'),
            'option2' => $request->get('option2'),
            'option3' => $request->get('option3'),
            'option4' => $request->get('option4'),
            'option5' => $request->get('option5'),
		]);
    

        session()->flash('flash.banner', 'Feedback criado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Feedback created successfully.');
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o feedback não foi criado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Feedback has not been registered')->setStatusCode(500);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\feedback  $feedbacks
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
		if(Feedbacks::where('id', $id)->exists()){	
        $feedback = Feedbacks::find($id);
         return Inertia::render('Panel/feedbacks/show', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de feedbacks | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de feedbacks',
             'breadcrumbCurrentSection' => 'Feedbacks',
             'feedback' => $feedback,
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
        } else {
        session()->flash('flash.banner', 'Feedback não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Feedback not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do feedback!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve feedback data')->setStatusCode(500);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\feedback  $feedbacks
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
		if(Feedbacks::where('id', $id)->exists()){	
        $feedback = Feedbacks::find($id);
    
         return Inertia::render('Panel/feedbacks/edit', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de feedbacks| Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de feedbacks',
             'breadcrumbCurrentSection' => 'Feedbacks',
             'feedback' => $feedback,
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
        } else {
        session()->flash('flash.banner', 'Feedback não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Feedback not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do feedback!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve feedback data')->setStatusCode(500);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\feedback  $feedbacks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'question' => 'string|required',
            'option1' => 'string|required',
            'option2' => 'string|required',
            'option3' => 'string|nullable',
            'option4' => 'string|nullable',
            'option5' => 'string|nullable',
        ]);
        try{
		if(Feedbacks::where('id', $id)->exists()){	

        $feedback = Feedbacks::find($id);
        $feedback->update([
            'author' => Auth()->User()->name,
            'question' => $request->get('question'),
            'option1' => $request->get('option1'),
            'option2' => $request->get('option2'),
            'option3' => $request->get('option3'),
            'option4' => $request->get('option4'),
            'option5' => $request->get('option5'),
		]);
  

        session()->flash('flash.banner', 'Feedback atualizado com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Feedback updated successfully');
        } else {
        session()->flash('flash.banner', 'Feedback não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Feedback has not been updated');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o Feedback não foi atualizado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Feedback has not been updated')->setStatusCode(500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\feedback  $feedbacks
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
		if(Feedbacks::where('id', $id)->exists()){	
        Feedbacks::find($id)->delete();
		
        session()->flash('flash.banner', 'Feedback excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Feedback deleted successfully');
        } else {
        session()->flash('flash.banner', 'Feedback não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Feedback has not been deleted');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o feedback não foi excluido!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Feedback has not been deleted')->setStatusCode(500);
        }
    }
}
