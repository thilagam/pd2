<?php namespace App\Http\Controllers;

use App\CepCountry;
use App\CepLanguages;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Validator;

class CountryController extends Controller {

	public $configs;
	public $permit;
	public $dictionary;
	public $countries;
	public $language_array;
	public $create_rules;
	public $create_msgs;
	public $validate;
	public $country;
	/*
        |--------------------------------------------------------------------------
        | Country
        |--------------------------------------------------------------------------
        |
        | CRUD Country
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
    	$this->dictionary = $request->attributes->get('dictionary');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(!$this->permit->crud_countries)
            return redirect('accessDenied');
		//$countries = CepCountry::with('language')->get();
		//return view('countries.index',compact('countries'));
		$this->countries = CepCountry::with('language')->get();
		return view('countries.index')->with(array('countries'=>$this->countries));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_countries_create)
            return redirect('accessDenied');
		/*$languages=CepLanguages::all();
		$languages_array=array();
		$languages_array[""]='Select';
		foreach($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}
		return view('countries.create', compact('languages_array'));
		*/
		$this->language_array = CepLanguages::lists('lang_name','lang_code');
		return view('countries.create')->with(array('languages_array'=>$this->language_array));
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		/*$countries=Request::all();
		$validate = Validator::make($countries,[
                            'country_name' => 'required|unique:cep_countries|max:45',
                            'country_code' => 'required|unique:cep_countries|max:3',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		CepCountry::create($countries);*/
		$this->countries = Request::all();
		$this->create_rules = array('country_name' => 'required|unique:cep_countries|max:45','country_code'=>'required|unique:cep_countries|max:3');
		$this->create_msgs = array('country_name.required'=>$this->dictionary->country_name_required,'country_name.unique'=>$this->dictionary->country_name_unique,'country_name.max'=>$this->dictionary->country_name_max,'country_code.required'=>$this->dictionary->country_code_required,'country_code.unique'=>$this->dictionary->country_code_unique,'country_code.max'=>$this->dictionary->country_code_max);
		$this->validate = Validator::make($this->countries,$this->create_rules,$this->create_msgs);
		if($this->validate->fails()){
			return redirect()->back()->withErrors($this->validate->errors());
		}
		CepCountry::create($this->countries);
		return redirect('countries');
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
		if(!$this->permit->crud_countries_read)
            return redirect('accessDenied');

		/*$country=CepCountry::where('country_id', $id)->first();

		$languages=CepLanguages::all();
		$languages_array=array();
		foreach($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}

		return count($country) ? view("countries.show", compact('country','languages_array')) : abort(404);*/
		$this->country = CepCountry::join('cep_languages','cep_countries.country_language_code','=','cep_languages.lang_code')->select('cep_countries.*','cep_languages.lang_name')->where('country_id',$id)->first();
		return count($this->country) ? view('countries.show')->with(array('country'=>$this->country)) : abort(404);

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
		if(!$this->permit->crud_countries_edit)
            return redirect('accessDenied');

		/*$country=CepCountry::where('country_id', $id)->first();
		$languages=CepLanguages::all();
		$languages_array=array();
		foreach($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}

		return count($country) ? view("countries.edit", compact('country','languages_array')) : abort(404);*/
		$this->country = CepCountry::where('country_id',$id)->first();
		$this->language_array = CepLanguages::lists('lang_name','lang_code');
		return count($this->country) ? view('countries.edit')->with(array('country'=>$this->country),'languages_array'=>$this->language_array)) : abort(404);

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
		$countryUpdate=Request::all();
		$country=CepCountry::where('country_id', $id)->first();
		array_shift($countryUpdate);
		array_shift($countryUpdate);
		$validate = Validator::make($countryUpdate,[
                            'country_name' => 'required|unique:cep_countries,country_name,'.$id.',country_id|max:45',
                            'country_code' => 'required|unique:cep_countries,country_code,'.$id.',country_id|max:3',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }

		$affectedRows = CepCountry::where('country_id','=',$id)->update($countryUpdate);
		return redirect("countries");
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
		if(!$this->permit->crud_countries_delete)
            return redirect('accessDenied');
		CepCountry::where('country_id',$id)->delete();
		return redirect("countries");
	}

}
