<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Settings;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use DB; use Auth; use Arr; use Str;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish update|edit system|delete update', ['only' => ['index','show']]);
         $this->middleware('permission:publish update', ['only' => ['create','store']]);
         $this->middleware('permission:edit update', ['only' => ['edit','update']]);
         $this->middleware('permission:delete update', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
		if(pages::where('welcome', true)->exists()){	
        $welcome = Cache::get('welcome', function () {
             $page = pages::where('welcome', true)->first();
             Cache::put('welcome', $page);
			 return $page;
        });
        $welcomebody = Cache::get('welcomebody', function () {
             $pagebody = pagesbody::where('page_id', $page->id)->first();
             Cache::put('welcome', $page);
			 return $pagebody;
        });
        return Inertia::render('pagerendering', [
		     'page' => $welcome,
		     'pagebody' => $welcomebody,
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
		]);
        } else {
        session()->flash('flash.banner', 'Página não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return Inertia::render('ErrorComponent', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
		]);
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do página!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve página data')->setStatusCode(500);
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
         ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
		if(pages::where('url', $id)->orWhere('id', $id)->exists()){	
        $page = pages::where('url', $id)->orWhere('id', $id)->first();
        $pagebody = pagesbody::where('page_id', $page->id)->first();
		 if(session()->has('views')){
		 if(!collect(session()->get('views'))->where('id', $page->id)->count() === 0){
			session()->push('views', ['id' => $page->id]);
			$page->update(['views' => intval($page->views) + 1]);
		 }
		 } else {
			session()->put('views', array());
			session()->push('views', ['id' => $page->id]);
			$page->update(['views' => intval($page->views) + 1]);
		 }	
        return Inertia::render('pagerendering', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => $page->title ?? 'Sem titulo',
             'page' => $page,
             'pagebody' => $pagebody,
             'version' => '2.0.5',
         ]);
        } else {
        session()->flash('flash.banner', 'Página não encontrada.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','Página not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do página!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve página data')->setStatusCode(500);
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
