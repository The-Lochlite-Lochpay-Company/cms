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
use lochlite\cms\Models\Fileupload;

use lochlite\cms\Controllers\Controller;
use Spatie\Permission\Models\Role; use Spatie\Permission\Models\Permission;
use Lochlitecms; use Carbon\Carbon; use Inertia\Inertia; use Artisan; use Storage; use Config; use DB; use Mail; use Hash; use Route; use Auth; use Arr; use Str;

class StorangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publish fileupload|edit fileupload|delete fileupload', ['only' => ['index','show']]);
         $this->middleware('permission:publish fileupload', ['only' => ['create','store']]);
         $this->middleware('permission:edit fileupload', ['only' => ['edit','update']]);
         $this->middleware('permission:delete fileupload', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = FileUpload::paginate();
		 if (request()->wantsJson()) {
           return $files;
         }
         return Inertia::render('Panel/fileupload/index', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Armazenamento de arquivos | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Armazenamento de arquivos',
             'breadcrumbCurrentSection' => 'Armazenamento',
             'files' => $files,
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
         return Inertia::render('Panel/fileupload/create', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Armazenamento de arquivos | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Armazenamento de arquivos',
             'breadcrumbCurrentSection' => 'Armazenamento',
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
        $currentfile = $request->file('file');
        $path = Storage::putFile('uploads', $currentfile);
        $url = Storage::url($path);
        $size = Storage::size($path);
        $name = $currentfile->getClientOriginalName();
        $type = $currentfile->getClientMimeType();
        $typesystem = $currentfile->getMimeType();

        $saveupload = Fileupload::create([
            'user_id' => Auth()->User()->id,
            'user_name' => Auth()->User()->name,
            'visitor' => $request->ip(),
            'filename' => $name,
            'size' => $size,
            'url' => $url,
            'path' => $path,
            'mimetype' => $type,
            'status' => 'success',
		]);

        return response()->json(['success' => '', 'name' => $name, 'url' => $url]);

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
		if(Fileupload::where('id', $id)->exists()){	
        $file = Fileupload::find($id);
         return Inertia::render('Panel/fileupload/show', [
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'title' => 'Armazenamento de arquivos | Lochlite CMS',
             'role' => Auth::User()->hasrole(['admin', 'Admin', 'administrador', 'Administrador']) == true ? 'Administrador' : Auth::User()->roles->pluck('name','name')->first() ?? 'Usuário',
             'avatar' => Auth::User()->avatar ?? '/assets/images/faces-clipart/pic-1.png',
             'name' => Auth::User()->name ?? 'User Name',
             'breadcrumbCurrentTitle' => 'Armazenamento de arquivos',
             'breadcrumbCurrentSection' => 'Artigos',
             'file' => $file,
             'fileurl' => asset($file->url),
             'version' => Lochlitecms::application()->get('version'),
         ])->rootview('lochlitecms::admin');
        } else {
        session()->flash('flash.banner', 'Arquivo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','File not found');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Falha ao recuperar os dados do arquivo!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','Failed to retrieve file data')->setStatusCode(500);
        }
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
        try{
		if(Fileupload::where('id', $id)->exists()){	
        $file = Fileupload::where('id', $id)->first();
        if(Storage::exists($file->path)){
            Storage::delete($file->path);
            $file->delete();
        }else{
            $file->delete();
        }
        session()->flash('flash.banner', 'Arquivo excluido com sucesso.');
        session()->flash('flash.bannerStyle', 'success');    
        return redirect()->back()->with('success','File deleted successfully');
        } else {
        session()->flash('flash.banner', 'Arquivo não encontrado.');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('success','File has not been deleted');
        }
		} catch(\Exception $e){
        session()->flash('flash.banner', 'Ocorreu um erro, o arquivo não foi excluido!');
        session()->flash('flash.bannerStyle', 'danger');    
        return redirect()->back()->with('error','File has not been deleted')->setStatusCode(500);
        }
    }
}
