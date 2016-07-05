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
		$countries = CepCountry::with('language')->get();
		return view('countries.index',compact('countries'));
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
		}*/
		$languages_array = CepLanguages::lists('lang_name','lang_code');

		return view('countries.create', compact('languages_array'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$countries=Request::all();
		$validate = Validator::make($countries,[
                            'country_name' => 'required|unique:cep_countries|max:45',
                            'country_code' => 'required|unique:cep_countries|max:3',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		CepCountry::create($countries);
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

		$country=CepCountry::where('country_id', $id)->first();

		$languages=CepLanguages::all();
		$languages_array=array();
		foreach($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}

		return count($country) ? view("countries.show", compact('country','languages_array')) : abort(404);
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

		$country=CepCountry::where('country_id', $id)->first();
		$languages=CepLanguages::all();
		$languages_array=array();
		foreach($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}

		return count($country) ? view("countries.edit", compact('country','languages_array')) : abort(404);
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
