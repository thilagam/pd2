<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\CepActivityTemplates;
use App\CepActivityTypes;
use App\CepLanguages;
use App\CepActivityTemplatesPlus;


use Request;
use Validator;

class ActivityTemplateController extends Controller {


	public $configs;
	public $permit;
	public $activity_temp_dictionary;
	public $act_templates_index;
	public $activity_temp_templates;
	public $activity_temp_type;
	public $activity_temp_language;
	public $acttemplates;
	/*
	|--------------------------------------------------------------------------
	| Config
	|--------------------------------------------------------------------------
	|
	| Define all Config Setting here
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
    	$this->activity_temp_dictionary=$request->attributes->get('dictionary');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(!$this->permit->crud_activity_templates)
            return redirect('accessDenied');

		/*$act_templates = CepActivityTemplates::leftjoin('cep_activity_templates_plus','actmp_id','=','actmpplus_template_id')
						      ->leftjoin('cep_activity_types','acttype_id','=','actmpplus_type')
						      ->leftjoin('cep_languages','actmpplus_language_code','=','lang_code')
						      ->get();
		return view('activity_templates.index',compact('act_templates'));*/
		$this->act_templates_index = CepActivityTemplates::leftjoin('cep_activity_templates_plus','actmp_id','=','actmpplus_template_id')
						      ->leftjoin('cep_activity_types','acttype_id','=','actmpplus_type')
						      ->leftjoin('cep_languages','actmpplus_language_code','=','lang_code')
						      ->get();
		return view('activity_templates.index')->with(array('act_templates'=>$this->act_templates_index));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_activity_templates_create)
            return redirect('accessDenied');

		/*$act_templates_array = CepActivityTemplates::where('actmp_status',1)->get();
		$act_templates = array();
		$act_templates[0] = "Select";
		foreach($act_templates_array as $act)
			$act_templates[$act->actmp_id] = $act->actmp_name;

		$act_templates_type_array = CepActivityTypes::where('acttype_status',1)->get();
                $act_templates_type = array();
                $act_templates_type[0] = "Select";
                foreach($act_templates_type_array as $type)
                        $act_templates_type[$type->acttype_id] = $type->acttype_name;

		$languages_array = CepLanguages::where('lang_status',1)->get();
                $languages = array();
                $languages[0] = "Select";
                foreach($languages_array as $lang)
                        $languages[$lang->lang_code] = $lang->lang_name;
        return view('activity_templates.create',compact('act_templates','act_templates_type','languages'));*/

        $this->activity_temp_templates = CepActivityTemplates::where('actmp_status',1)->lists('actmp_name','actmp_id');
        $this->activity_temp_type = CepActivityTypes::where('acttype_status',1)->lists('acttype_name','acttype_id');
        $this->activity_temp_language = CepLanguages::where('lang_status',1)->lists('lang_name','lang_code');
        return view('activity_templates.create')->with(array('act_templates'=>$this->activity_temp_templates,'act_templates_type'=>$this->activity_temp_type,'languages'=>$this->activity_temp_language));
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$acttemplates = Request::only('actmp_id','actmp_name','actmp_description');

		$acttemplates_i = Request::only('actmpplus_language_code','actmpplus_type','actmpplus_template');
		if($acttemplates['actmp_id'] == 0){
                        $validate = Validator::make($acttemplates,[
                                                'actmp_name' => 'required',
                                                'actmp_description' => 'required',
                        ]);
                        $validate = Validator::make($acttemplates_i,[
                                                'actmpplus_language_code' => 'required',
                                                'actmpplus_type' => 'required',
                                                'actmpplus_template' => 'required',
                        ]);
                        if($validate->fails()){
                                return redirect()->back()->withErrors($validate->errors());
                        }

		//	print_r ($acttemplates); print_r ($acttemplates_i); exit;

			$temp = CepActivityTemplates::create($acttemplates);
			$acttemplates_i['actmpplus_template_id'] = $temp['actmp_id'];
                        CepActivityTemplatesPlus::create($acttemplates_i);

		}else{

			$acttemplates_i['actmpplus_template_id'] = $acttemplates['actmp_id'];
			$validate = Validator::make($acttemplates_i,[
						'actmp_id' => 'actmpplus_template_id',
                				'actmpplus_language_code' => 'required',
 			    			'actmpplus_type' => 'required',
						'actmpplus_template' => 'required',
                 	]);
		 	if($validate->fails()){
				return redirect()->back()->withErrors($validate->errors());
                 	}
			CepActivityTemplatesPlus::cctmp_descriptionactmp_descriptionreate($acttemplates_i);
		}
		return redirect('activity-templates');
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
				if(!$this->permit->crud_activity_templates_read)
            		return redirect('accessDenied');

                //$act_templates_all = CepActivityTemplates::all();
                $this->acttemplates = CepActivityTemplates::leftjoin('cep_activity_templates_plus','actmp_id','=','actmpplus_template_id')
                                                      ->leftjoin('cep_activity_types','acttype_id','=','actmpplus_type')
                                                      ->leftjoin('cep_languages','actmpplus_language_code','=','lang_code')
                                                      ->select('cep_activity_templates.actmp_name','cep_activity_templates_plus.*','cep_activity_types.acttype_name','cep_languages.lang_name')
						      ->where('actmpplus_id',$id)
                                                      ->first();
                //$languages = CepLanguages::where('lang_status',1)->get();
                //$act_templates_type = CepActivityTypes::all();


       //return count($act_templates) ? view('activity_templates.show',compact('act_templates','languages','act_templates_type','act_templates_all')) : abort(404);
        return count($this->acttemplates) ? view('activity_templates.show')->with(array('act_templates'=>$this->acttemplates)) : abort(404);                                              
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
				if(!$this->permit->crud_activity_templates_edit)
            		return redirect('accessDenied');

                $act_templates_array = CepActivityTemplates::where('actmp_status',1)->get();
                $act_templates = array();
                $act_templates[0] = "Select";
                foreach($act_templates_array as $act)
                        $act_templates[$act->actmp_id] = $act->actmp_name;

                $act_templates_type_array = CepActivityTypes::where('acttype_status',1)->get();
                $act_templates_type = array();
                $act_templates_type[0] = "Select";
                foreach($act_templates_type_array as $type)
                        $act_templates_type[$type->acttype_id] = $type->acttype_name;

                $languages_array = CepLanguages::where('lang_status',1)->get();
                $languages = array();
                $languages[0] = "Select";
                foreach($languages_array as $lang)
                        $languages[$lang->lang_code] = $lang->lang_name;

                $act_templates_i = CepActivityTemplates::leftjoin('cep_activity_templates_plus','actmp_id','=','actmpplus_template_id')
                                                      ->leftjoin('cep_activity_types','acttype_id','=','actmpplus_type')
                                                      ->leftjoin('cep_languages','actmpplus_language_code','=','lang_code')
                                                      ->where('actmpplus_id',$id)
                                                      ->first();

      return count($act_templates_i) ? view('activity_templates.edit',compact('act_templates','act_templates_type','languages','act_templates_i')) : abort(404);


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
                $acttemplates_i = Request::only('actmpplus_language_code','actmpplus_type','actmpplus_template','actmpplus_status','actmpplus_template_id');
		$validate = Validator::make($acttemplates_i,[
                                                'actmpplus_status' => 'required',
                                                'actmpplus_language_code' => 'required',
                                                'actmpplus_type' => 'required',
                                                'actmpplus_template' => 'required',
						'actmpplus_template_id' => 'required'
                        ]);
                        if($validate->fails()){
                                return redirect()->back()->withErrors($validate->errors());
                        }
		CepActivityTemplatesPlus::where('actmpplus_id',$id)->update($acttemplates_i);
		return redirect('activity-templates');
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
		if(!$this->permit->crud_activity_templates_delete)
            return redirect('accessDenied');
		CepActivityTemplatesPlus::where('actmpplus_id',$id)->delete();
		return redirect('activity-templates');

	}

}
