<?php namespace App\Http\Controllers;

use App\CepLanguages;
//use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;

use Request;
use Validator;
use Cookie;

use DB;
use Auth;

class LanguageController extends Controller {

	public $configs;
	public $permit;
        /*
        |--------------------------------------------------------------------------
        | Language
        |--------------------------------------------------------------------------
        |
        | CRUD Language
        |
        */

        /**
         * Create a new controller instance.
         *
         * @return void
         */

	public function __construct(\Illuminate\Http\Request $request)
	{
             $this->middleware('auth');
             $this->permit=$request->attributes->get('permit');
    		 $this->configs=$request->attributes->get('configs');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		//
		if(!$this->permit->crud_languages)
            return redirect('accessDenied');
		$languages = CepLanguages::all();
		return view('languages.index', compact('languages'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_languages_create)
            return redirect('accessDenied');
		return view('languages.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$language=Request::all();
                $validate = Validator::make($language,[
                            'lang_name' => 'required|max:45',
 			    'lang_code' => 'required|unique:cep_languages|max:3',
                 ]);

                if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());
                }
  		CepLanguages::create($language);
		return redirect('languages');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		if(!$this->permit->crud_languages_read)
            return redirect('accessDenied');
		$language=CepLanguages::where('lang_id', $id)->first();
       		return count($language) ? view('languages.show',compact('language')) : abort(404);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		if(!$this->permit->crud_languages_edit)
            return redirect('accessDenied');
		$language=CepLanguages::where('lang_id', $id)->first();
	        return count($language) ? view('languages.edit',compact('language')) : abort(404);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
    	        $languageUpdate=Request::only('lang_name','lang_code','lang_status');
							$language = CepLanguages::where('lang_id', $id)->first();
              $validate = Validator::make($languageUpdate,[
                            'lang_name' => 'required|max:45',
                            'lang_code' => 'required|unique:cep_languages,lang_code,'.$id.',lang_id|max:3',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
	        $affectedRows = CepLanguages::where('lang_id', '=', $id)->update($languageUpdate);
	        return redirect('languages');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		if(!$this->permit->crud_languages_delete)
            return redirect('accessDenied');
		CepLanguages::where('lang_id', $id)->delete();
	        return redirect('languages');
	}

}
