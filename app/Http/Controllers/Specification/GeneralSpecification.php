<?php namespace App\Http\Controllers\Specification;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\CepModels\Specification\CepSpecificationGenerals;
use App\CepModels\Specification\CepSpecificationMasters;
use Request;
use Validator;
use Carbon\Carbon;
use Auth;
use App\CepLanguages;


class GeneralSpecification extends Controller {


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
		if(!$this->permit->crud_general_specifications)
            return redirect('accessDenied');

		$generalSpecs = CepSpecificationGenerals::all();
		return view('general_specifications.index',compact('generalSpecs'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_general_specifications_create)
            return redirect('accessDenied');

        $languages = CepLanguages::all();
		$languages_array = array();
		foreach ($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}
		return view('general_specifications.create',compact('languages_array'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$generalSpecs = Request::all();
		$generalSpecs['specgen_url'] = preg_replace('/\d+/','DD',$generalSpecs['specgen_url']);
        $validate = Validator::make($generalSpecs,[
        	                 'specgen_description' => 'required',
        	                 'specgen_language_code' => 'required',
 						     //'specgen_url' => 'required|unique:cep_specification_generals',
 						     'specgen_url' => 'required',
                 	]);

        if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());
        }

        $masterSpecs = array( 'spec_type' => 'general',
        					  'spec_created_date' => Carbon::now(),
        					  'spec_created_by' => Auth::id()
        					);

        $master = CepSpecificationMasters::create($masterSpecs);
		$generalSpecs['specgen_spec_id'] = $master->spec_id;
        CepSpecificationGenerals::create($generalSpecs);

        return redirect('general-specifications');

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
		if(!$this->permit->crud_general_specifications_read)
            return redirect('accessDenied');

        $languages = CepLanguages::all();
		$languages_array = array();
        foreach ($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}
		$generalSpecs = CepSpecificationGenerals::where("specgen_id",$id)->first();
		return count($generalSpecs) ? view('general_specifications.show',compact('generalSpecs','languages_array')) : abort(404);
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
		if(!$this->permit->crud_general_specifications_update)
            return redirect('accessDenied');

        $languages = CepLanguages::all();
		$languages_array = array();
        foreach ($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}
		$generalSpecs = CepSpecificationGenerals::where("specgen_id",$id)->first();
		return count($generalSpecs) ? view('general_specifications.edit',compact('generalSpecs','languages_array')) : abort(404);
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
		$generalSpecs = Request::only('specgen_description','specgen_url','specgen_spec_id','specgen_status','specgen_language_code');
        $validate = Validator::make($generalSpecs,[
        	                 'specgen_description' => 'required',
        	                 'specgen_language_code' => 'required',
 						     //'specgen_url' => 'required|unique:cep_specification_generals,specgen_url,'.$id.',specgen_id',
 						     'specgen_url' => 'required',
                 	]);

        if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());
        }

        $masterSpecs = array(
        					  'spec_updated_by' => Auth::id()
        					);

        CepSpecificationMasters::where('spec_id', $generalSpecs['specgen_spec_id'])->update($masterSpecs);
        CepSpecificationGenerals::where('specgen_id', $id)->update($generalSpecs);

        return redirect('general-specifications');

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
		if(!$this->permit->crud_general_specifications_delete)
            return redirect('accessDenied');

        	$ids = explode("-",$id);
			CepSpecificationGenerals::where('specgen_id', $ids[0])->delete();
			CepSpecificationMasters::where('spec_id', $ids[1])->delete();
	        return redirect('general-specifications');
	}

}
