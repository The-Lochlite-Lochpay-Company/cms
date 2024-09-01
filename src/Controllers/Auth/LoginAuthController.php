<?php
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.10 
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

namespace Lochlite\cms\Controllers\Auth;

use Illuminate\Http\Request;
use Lochlite\cms\Models\User;
use Lochlite\cms\App\Requests\Auth\LoginRequest;
use Lochlite\cms\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

use Lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Carbon\Carbon; use Inertia\Inertia; use Response; use Cache; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;
use Lochlitecms;

class LoginAuthController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
         return Lochlitecms::login($request);
    }
	
    public function google()
    {
        return Socialite::driver('google')->redirect();
    }
	
    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
	
    public function twitter()
    {
        return Socialite::driver('twitter')->redirect();
    }
	
    public function gameloch()
    {
        return;
    }
	
    public function googlecallback()
    {
        try {
            $drive = Socialite::driver('google')->user();
            if(User::where('google_id', $drive->id)->orWhere('email', $drive->email)->exists()){
                $user = User::where('google_id', $drive->id)->orWhere('email', $drive->email)->first();
                if(!$user->google_id == $drive->id){$user->update(['google_id' => $drive->id]); $user->save();}
				Auth::login($user);
                return redirect()->intended('dashboard');
            }else{
                $user = User::create([
				    'email' => $drive->email,
                    'name' => $drive->name,
                    'google_id'=> $drive->id,
                ]);
                Auth::login($user);
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
	}
	
    public function facebookcallback()
    {
        try {
            $drive = Socialite::driver('facebook')->user();
            if(User::where('facebook_id', $drive->id)->orWhere('email', $drive->email)->exists()){
                $user = User::where('facebook_id', $drive->id)->orWhere('email', $drive->email)->first();
                if(!$user->facebook_id == $drive->id){$user->update(['facebook_id' => $drive->id]); $user->save();}
				Auth::login($user);
                return redirect()->intended('dashboard');
            }else{
                $user = User::create([
				    'email' => $drive->email,
                    'name' => $drive->name,
                    'facebook_id'=> $drive->id,
                ]);
                Auth::login($user);
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
	
    public function twittercallback()
    {
        try {
            $drive = Socialite::driver('twitter')->user();
            if(User::where('twitter_id', $drive->id)->orWhere('email', $drive->email)->exists()){
                $user = User::where('twitter_id', $drive->id)->orWhere('email', $drive->email)->first();
                if(!$user->twitter_id == $drive->id){$user->update(['twitter_id' => $drive->id]); $user->save();}
				Auth::login($user);
                return redirect()->intended('dashboard');
            }else{
                $user = User::create([
				    'email' => $drive->email,
                    'name' => $drive->name,
                    'twitter_id'=> $drive->id,
                ]);
                Auth::login($user);
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
	
    public function gamelochcallback()
    {
        return;
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
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
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
    public function destroy(Request $request)
    {
        Lochlitecms::setHistory($action = 'logout', $description = 'The user voluntarily logged out on the day: ' . now(), Auth()->User());
		Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index.index');
    }
}
