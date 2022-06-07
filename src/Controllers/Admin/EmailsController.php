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
use lochlite\cms\Models\Emails;
use lochlite\cms\Mail\DefaultMail;
use lochlite\cms\Mail\TwoMail;
use lochlite\cms\Mail\ThreeMail;
use lochlite\cms\Mail\FourMail;
use lochlite\cms\Mail\FiveMail;
use lochlite\cms\Mail\SixMail;
use lochlite\cms\Mail\SevenMail;
use lochlite\cms\Mail\EightMail;
use lochlite\cms\Mail\NineMail;
use lochlite\cms\Mail\TenMail;
use Spatie\MailTemplates\Models\MailTemplate;
use Newsletter as Mailchimp;

use lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class EmailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('auth:sanctum');
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
        $emails = Emails::latest()->paginate(15);
		 if (request()->wantsJson()) {
           return $emails;
         }
         return Inertia::render('Panel/emails/index', [
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
         ])->rootview('lochlitecms::admin');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $models = MailTemplate::all();
         return Inertia::render('Panel/emails/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de emails | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de emails',
             'breadcrumbCurrentSection' => 'Emails',
             'models' => $models,
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
            'emails' => 'required',
            'model' => 'numeric|required',
        ]);
		if(MailTemplate::where('id', $request->get('model'))->exists()){
		$model = MailTemplate::where('id', $request->get('model'))->first();
		$classMailable = $model->mailable;
        $emailslist = explode( ',' , $request->get('emails'));
	    $errors = [];
	    foreach($emailslist as $item){
		     $user = User::where('email', $item);
             if($user->exists())	{	
			 $Emailbody = (new $classMailable($user->first()))->render();
             $EmailSent = Mail::to($user->first()->email)->send(new $classMailable($user->first()));
             try{
             if($EmailSent instanceof \Illuminate\Mail\SentMessage){
             $emails = Emails::create([
                 'userid' => $user->first()->id,
                 'from' => Config::get('mail.from.address') ?? 'undefined',
                 'to' => $item,
                 'subject' => $model->subject,
                 'body' => $Emailbody,
                 'status' => 'failed',
		     ]);
             }else{
             $emails = Emails::create([
                 'userid' => $user->first()->id,
                 'from' => Config::get('mail.from.address') ?? 'undefined',
                 'to' => $item,
                 'subject' => $model->subject,
                 'body' => $Emailbody,
                 'status' => 'sent',
		     ]);
             }
			 } catch(\Exception $e){
             $errors[] = 'Não foi possivel registrar na base de dados a mensagem enviada para o email: '. $item;
             }
		     }
		}
		if(!empty($errors)){
		session()->flash('errors', $errors);
        }
        session()->flash('flash.banner', 'Operação concluida com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Email created successfully.');
    } else {
		session()->flash('flash.banner', 'O modelo de email selecionado não foi encontrado ou é invalido.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Model not found.');
    }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
		if(Emails::where('id', $id)->exists()){	
        $email = Emails::find($id);
         return Inertia::render('Panel/emails/show', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Gestão de emails | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Gestão de emails',
             'breadcrumbCurrentSection' => 'Emails',
             'email' => $email,
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
        } else {
        session()->flash('flash.banner', 'Email não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Email not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do email!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve email data');
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
		if(Emails::where('id', $id)->exists()){	
        $email = Emails::find($id)->delete();
        session()->flash('flash.banner', 'Email excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Email deleted successfully.');
        } else {
        session()->flash('flash.banner', 'Email não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Email not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do email!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve email data');
        }
     }

}
