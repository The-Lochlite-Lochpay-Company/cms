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
use Lochlite\cms\Models\Fileupload;
use Lochlite\cms\Models\Newsletter;
use Lochlite\cms\Models\Contacts;
use Lochlite\cms\Models\Pages;
use Lochlite\cms\Models\Pagesbody;
use Lochlite\cms\Models\Feedbacks;
use Lochlite\cms\Models\Feedbacksresponses;
use Newsletter as Mailchimp;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Carbon\Carbon; use Inertia\Inertia; use Response; use Cache; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;
use Lochlitecms;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(Pages::where('welcome', true)->exists()){	
        $page = Cache::get('welcome', function () {
             $welcome = Pages::where('welcome', true)->first();
             Cache::put('welcome', $welcome);
			 return $welcome;
        });
        $pagebody = Cache::get('welcomebody', function () use($page) {
             $welcomebody = Pagesbody::where('page_id', $page->id)->first();
             Cache::put('welcomebody', $welcomebody);
			 return $welcomebody;
        });
        return Inertia::render('vendor/lochlite/cms/src/Views/Components/pagerendering', [
		     'page' => $page,
		     'pagebody' => $pagebody,
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
		])->rootview('lochlitecms::app');
        } else {
        return Inertia::render('vendor/lochlite/cms/src/Views/Web/Welcome', [
             'title' => Lochlitecms::seo('title'),
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
		])->rootview('lochlitecms::app');
        }

    }

    /**
     * Show file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filefiling(Request $request, $date)
    {
        try{
		if(Fileupload::whereDate('created_at', $date)->where('url', $request->query('url'))->exists()){	
        $file = Fileupload::whereDate('created_at', $date)->where('url', $request->query('url'))->first();
		if (Storage::exists($file->path)) {
	    return response()->file(Storage::path($file->path));
        } elseif (Storage::disk('uploads')->exists($file->path)) {
	    return response()->file(Storage::disk('uploads')->path($file->path));
        } else {
        session()->flash('flash.banner', 'Este arquivo não existe mais no nosso sistema.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('success','This file no longer exists on our system.');
		}
		
        } else {
        session()->flash('flash.banner', 'Arquivo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('success','File not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro ao recuperar os dados do arquivo.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('error','Failed to retrieve file data')->setStatusCode(500);
        }
    }

    /**
     * Webmanifest file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function application($path)
    {
        try{

		if (Lochlitecms::cmsFetchPublicDisk()->exists($path)) {
	    return response()->file(Lochlitecms::cmsFetchPublicDisk()->path($path));
        } else {
        session()->flash('flash.banner', 'Este arquivo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index.index')->with('success','This file no longer exists on our system.');
		}
		
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro ao recuperar os dados do arquivo.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index.index')->with('error','Failed to retrieve file data')->setStatusCode(500);
        }
    }

    /**
     * Webmanifest file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pwa()
    {
     return Lochlitecms::pwaManifest();
    }

    /**
     * Download file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        try{
		if(Fileupload::where('id', $id)->exists()){	
         $file = Fileupload::find($id);
         return Storage::download($file->path, $file->filename);
        } else {
        session()->flash('flash.banner', 'Arquivo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','File not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do arquivo.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve file data')->setStatusCode(500);
        }
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscriptnewsletter(Request $request)
    {
        request()->validate([
            'email' => 'email:rfc,dns|required|min:6|max:255',
        ]);
        try{
		if(!Newsletter::where('email', $request->get('email'))->exists() && !Mailchimp::isSubscribed($request->get('email'))){	
        Mailchimp::subscribe($request->get('email'));
		if(Mailchimp::lastActionSucceeded()){	
        session()->flash('flash.banner', 'Parabéns! Você foi inscrito na nossa Newsletter, até mais!');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Congratulations! You have been subscribed to our Newsletter, see you later!');
        } else {
        session()->flash('flash.banner', 'Um erro impediu a sua inscrição, contacte o administrador para mais informações.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('error','An error prevented your registration, contact the administrator for more information.');
		}
        } else {
        session()->flash('flash.banner', 'Esse e-mail já foi cadastrado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('error','This email has already been registered');
		}
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, você não foi inscrito na nossa Newsletter!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','An error has occurred, you have not been subscribed to our Newsletter!')->setStatusCode(500);
        }
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unsubscribenewsletter(Request $request, $email)
    {
        try{$request->session()->put('requestunsubscribe', intval($request->session()->get('requestunsubscribe') ?? 0) + 1);
		if(session()->get('requestunsubscribe') >= 5){
        session()->flash('flash.banner', 'Requisições em excesso, tente novamente mais tarde.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('error','Too many requests, please try again later.')->setStatusCode(429);
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        session()->flash('flash.banner', 'Email invalido! Verifique o email e tente novamente.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('error','Invalid email! Check the email and try again.')->setStatusCode(404);
        } else {
		if(Newsletter::where('email', $email)->exists()){	
        Mailchimp::unsubscribe($email);
        session()->flash('flash.banner', 'Sua assinatura foi cancelada com sucesso, você não receberá mais e-mails.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('success','Your subscription has been successfully canceled, you will no longer receive emails.');
        } else {
        session()->flash('flash.banner', 'E-mail não encontrado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('error','Email not found')->setStatusCode(500);
		}
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, seu e-mail não foi removido de nossa Newsletter!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->route('index')->with('error','An error has occurred, your email has not been removed from our Newsletter!')->setStatusCode(500);
        }
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
         return Inertia::render('Contact', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
         ])->rootview('lochlitecms::app');
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendcontact(Request $request)
    {
        request()->validate([
            'name' => 'string|required|min:6|max:255',
            'email' => 'email:rfc,dns|required|min:6|max:255',
            'message' => 'string|required|min:20|max:255',
        ]);
        try{
		if(Contacts::where('visitor', request()->getClientIp())->whereTime('created_at', '>', Carbon::now()->subMinutes(30)->toDateTimeString())->exists()){	
        session()->flash('flash.banner', 'Você enviou uma mensagem recentemente, tente novamente mais tarde!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Your message has not been registered.')->setStatusCode(429);
        } else {
        $contact = Contacts::create([
            'visitor' => request()->getClientIp(),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'message' => $request->get('message'),
		]);
        session()->flash('flash.banner', 'Sua mensagem foi recebida com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Contact received successfully.');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Sua mensagem não foi registrada!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Your contact has not been registered')->setStatusCode(500);
        }
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function feedback()
    {
         $questions = Feedbacks::all();
         return Inertia::render('Feedback', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'questions' => $questions,
         ]);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendfeedback(Request $request)
    {
        request()->validate([
            'name' => 'string|required|min:6|max:255',
            'email' => 'email:rfc,dns|required|min:6|max:255',
            'responses' => 'array|required',
        ]);
        try{
		if(Feedbacksresponses::where('visitor', request()->getClientIp())->whereTime('created_at', '>', Carbon::now()->subMinutes(30)->toDateTimeString())->exists()){	
        session()->flash('flash.banner', 'Você registrou um feedback recentemente, tente novamente mais tarde!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Your feedback has not been registered.')->setStatusCode(429);
        } else {
        $feedback = Feedbacksresponses::create([
            'visitor' => request()->getClientIp(),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'responses' => json_encode($request->get('responses')),
		]);
        session()->flash('flash.banner', 'Seu feedbeck foi recebido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','Feedback received successfully.');
        }
        } catch(\Exception $e){
        session()->flash('flash.banner', 'Seu feedback não foi registrado!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Your feedback has not been registered.')->setStatusCode(500);
        }
    }
}
