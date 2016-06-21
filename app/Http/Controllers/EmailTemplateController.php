<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;

use App\CepEmailTemplates;
use App\CepLanguages;
use App\CepEmailTemplatesPlus;
use Validator;


class EmailTemplateController extends Controller {

	public $configs;
	public $permit;
	/*
	|--------------------------------------------------------------------------
	| Email Template
	|--------------------------------------------------------------------------
	|
	| Define all Email Template Setting here
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
		if(!$this->permit->crud_email_templates)
            return redirect('accessDenied');

		$etemplates = CepEmailTemplates::
						leftjoin("cep_email_templates_plus",'etemp_id','=','etempplus_template_id')
						->leftjoin("cep_languages",'etempplus_language_code','=','lang_code')
						->where("etemp_status",1)
						->get();
		return view("email_templates.index",compact('etemplates'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_email_templates_create)
            return redirect('accessDenied');

		$languages_array = CepLanguages::where('lang_status',1)->get();
		$languages = array();
		$languages[""] = "Select";
		foreach($languages_array as $la)
			$languages[$la->lang_code] = $la->lang_name;

		$templates_array = CepEmailTemplates::where('etemp_status',1)->get();
		$templates_all = array();
		$templates_all["0"] = "Select";
		foreach($templates_array  as $ta)
			$templates_all[$ta->etemp_id] = $ta->etemp_name;

		return view("email_templates.create",compact('languages','templates_all'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$etemplate = Request::only('etemp_name','etemp_description','etempplus_template_id');
		$etemplate_plus = Request::only('etempplus_language_code','etempplus_template_code');

		if($etemplate['etempplus_template_id']  == 0){
			$validate = Validator::make($etemplate,[
            				    'etemp_name' => 'required|max:60',
 			    				'etemp_description' => 'required',
                 		]);
			$validate = Validator::make($etemplate_plus,[
							    'etempplus_language_code' => 'required',
							    'etempplus_template_code' => 'required',
                 		]);
		 	if($validate->fails()){
				return redirect()->back()->withErrors($validate->errors());
            }
  				$etemp_data = CepEmailTemplates::create($etemplate);
  				$etemplate_plus['etempplus_template_id'] = $etemp_data->etemp_id;
  				CepEmailTemplatesPlus::create($etemplate_plus);
  		}else {
  				$validate = Validator::make($etemplate_plus,[
							    'etempplus_language_code' => 'required',
							    'etempplus_template_code' => 'required',
                ]);
		 	if($validate->fails()){
				return redirect()->back()->withErrors($validate->errors());
            }
             $etemplate_plus['etempplus_template_id'] = $etemplate['etempplus_template_id'];
             CepEmailTemplatesPlus::create($etemplate_plus);

  		}
		return redirect('email-templates');

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
		if(!$this->permit->crud_email_templates_read)
            return redirect('accessDenied');


                $languages = CepLanguages::where('lang_status',1)->get();

                $templates_array = CepEmailTemplates::where('etemp_status',1)->get();
				$templates_all = array();
				$templates_all["0"] = "Select";
				foreach($templates_array  as $ta)
					$templates_all[$ta->etemp_id] = $ta->etemp_name;

				$etemplate = CepEmailTemplates::
						leftjoin("cep_email_templates_plus",'etemp_id','=','etempplus_template_id')
						->leftjoin("cep_languages",'etempplus_language_code','=','lang_code')
						->where("etemp_status",1)
						->where("etempplus_id",$id)
						->first();

        return count($etemplate) ? view("email_templates.show",compact('languages','etemplate','templates_all')) : abort(404);

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

		if(!$this->permit->crud_email_templates_edit)
            return redirect('accessDenied');

                $languages_array = CepLanguages::where('lang_status',1)->get();
                $languages = array();
                $languages[""] = "Select";
                foreach($languages_array as $la)
                        $languages[$la->lang_code] = $la->lang_name;

                $templates_array = CepEmailTemplates::where('etemp_status',1)->get();
				$templates_all = array();
				$templates_all["0"] = "Select";
				foreach($templates_array  as $ta)
					$templates_all[$ta->etemp_id] = $ta->etemp_name;

				$etemplate = CepEmailTemplates::
						leftjoin("cep_email_templates_plus",'etemp_id','=','etempplus_template_id')
						->leftjoin("cep_languages",'etempplus_language_code','=','lang_code')
						->where("etemp_status",1)
						->where("etempplus_id",$id)
						->first();

        return count($etemplate) ? view("email_templates.edit",compact('languages','etemplate','templates_all')) : abort(404);

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
                $etemplate = Request::only('etempplus_language_code','etempplus_template_id','etempplus_template_code','etempplus_status');
                $validate = Validator::make($etemplate,[
                            'etempplus_template_id' => 'required',
                            'etempplus_language_code' => 'required',
                            'etempplus_template_code' => 'required',
                 ]);
                 if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                 }
                CepEmailTemplatesPlus::where('etempplus_id',$id)->update($etemplate);
                return redirect('email-templates');

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
		if(!$this->permit->crud_email_templates_delete)
            return redirect('accessDenied');
		CepEmailTemplatesplus::where('etempplus_id',$id)->delete();
		return redirect('email-templates');
	}

}
