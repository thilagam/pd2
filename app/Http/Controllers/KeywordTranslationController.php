<?php namespace App\Http\Controllers;

use App\CepLanguages;
use App\CepKeywords;

use App\CepKeywordTranslations;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Validator;

class KeywordTranslationController extends Controller {

	public $configs;
	public $permit;
        /*
        |--------------------------------------------------------------------------
        | KeywordTranslation
        |--------------------------------------------------------------------------
        |
        | CRUD KeywordTranslation
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
		if(!$this->permit->crud_keyword_translations)
            return redirect('accessDenied');
		$keyword_translations = CepKeywordTranslations::with('keyword','language')->get();
		return view('keyword_translations.index', compact('keyword_translations'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_keyword_translations_create)
            return redirect('accessDenied');

		$languages = CepLanguages::all();
		$keywords = CepKeywords::all();
		$languages_array = array();
		$keywords_array = array();
		foreach ($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}
		foreach ($keywords as $keyword){
			$keywords_array[$keyword->kw_id]=$keyword->kw_name;
		}

		return view('keyword_translations.create', compact('languages_array','keywords_array'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$keyword_translation = Request::all();
		$validate = Validator::make($keyword_translation,[
                            'kwtrans_keyword_id' => 'required',
                            'kwtrans_language_code' => 'required',
			    'kwtrans_word' => 'required|max:100',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		CepKeywordTranslations::create($keyword_translation);
		return redirect('keyword-translations');
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
		if(!$this->permit->crud_keyword_translations_read)
            return redirect('accessDenied');

		$keyword_translation = CepKeywordTranslations::where('kwtrans_id',$id)->first();
		$languages = CepLanguages::all();
		$keywords = CepKeywords::all();
		$languages_array = array();
		$keywords_array = array();
		foreach ($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}
		foreach ($keywords as $keyword){
			$keywords_array[$keyword->kw_id]=$keyword->kw_name;
		}
		return count($keyword_translation) ? view('keyword_translations.show', compact('keyword_translation','languages_array','keywords_array')) : abort(404);
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
		if(!$this->permit->crud_keyword_translations_edit)
            return redirect('accessDenied');

		$keyword_translation = CepKeywordTranslations::where('kwtrans_id',$id)->first();
		$languages = CepLanguages::all();
		$keywords = CepKeywords::all();
		$languages_array = array();
		$keywords_array = array();
		foreach ($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}
		foreach ($keywords as $keyword){
			$keywords_array[$keyword->kw_id]=$keyword->kw_name;
		}
		return count($keyword_translation) ? view('keyword_translations.edit', compact('keyword_translation','languages_array','keywords_array')) : abort(404);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$keyword_translationUpdates = Request::only('kwtrans_keyword_id','kwtrans_language_code','kwtrans_word','kwtrans_status');
                $validate = Validator::make($keyword_translationUpdates,[
                            'kwtrans_keyword_id' => 'required',
                            'kwtrans_language_code' => 'required',
                            'kwtrans_word' => 'required|max:100',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }

		CepKeywordTranslations::where('kwtrans_id',$id)->update($keyword_translationUpdates);
		return redirect('keyword-translations');

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
		if(!$this->permit->crud_keyword_translations_delete)
            return redirect('accessDenied');

		CepKeywordTranslations::where('kwtrans_id',$id)->delete();
		return redirect('keyword-translations');
	}

}
