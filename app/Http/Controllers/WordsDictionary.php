<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\CepLanguages;
use App\CepKeywords;
use App\CepKeywordTranslations;

use Illuminate\Support\Facades\Input;

class WordsDictionary extends Controller {

        /*
        |--------------------------------------------------------------------------
        | User Permission
        |--------------------------------------------------------------------------
        |
        | CRUD User Permission
        |
        */

	public $permissions;
	public $configs;

        /**
         * Create a new controller instance.
         *
         * @return void
         */

        public function __construct(\Illuminate\Http\Request $request)
        {	
    		    $this->permit=$request->attributes->get('permit');
    		    $this->configs=$request->attributes->get('configs');
        	    $this->middleware('auth');
        }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(!$this->permit->module_setting_language)
			return redirect('accessDenied');
		//
	       $languages  = CepLanguages::where("lang_status",1)->get();
	       $keywords = CepKeywords::where("kw_status",1)->get();
	       $keyword_translations = CepKeywordTranslations::where("kwtrans_status",1)->get();	
               $words_dictionary = array();
	       foreach($keyword_translations as $kwt){
		   		$words_dictionary[$kwt->kwtrans_keyword_id][$kwt->kwtrans_language_code] = $kwt->kwtrans_word;	
            }

         $selectLang = " <select class='lang_select form-control pull-right'>";
            foreach(CepLanguages::where("lang_status",1)->get() as $lang){
            	if($lang->lang_code == "en")
            		$selectLang .= "<option value=''>Select Language</option>";
            	else
            		$selectLang .= "<option value='".$lang->lang_id."'>".$lang->lang_name."(".$lang->lang_code.")"."</option>";
            }
            	$selectLang .= "</select>";    


               //print_r ($words_dictionary);
	       return view('words_dictionary.index', compact('languages','keywords','words_dictionary','selectLang'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
            $data = Input::all();
            print_r ($data);
	    $data_input = "";
            foreach($data as $key=>$dt){
            if(strcmp($key,"id") !== 0){
      $kw = CepKeywordTranslations::where("kwtrans_status",1)->where("kwtrans_keyword_id",$data['id'])->where("kwtrans_language_code",$key)->first();
           //print_r ($kw); 
	   if(isset($kw)){
            $updateValue = array('kwtrans_word'=>$dt);
  CepKeywordTranslations::where("kwtrans_status",1)->where("kwtrans_keyword_id",$data['id'])->where("kwtrans_language_code",$key)->update($updateValue);       
            }else{
            $data_input .= $key;
            $createValue = array('kwtrans_word'=>$dt,"kwtrans_keyword_id"=>$data['id'],"kwtrans_language_code"=>$key);
  CepKeywordTranslations::create($createValue);             
             } 	
	    }
           } 
	    print_r($data_input); 
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
                echo "hello";
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
		//echo $id;
		if(!$this->permit->module_setting_language)
			return redirect('accessDenied');
		// 
		   $id = 'en+'.$this->langCodeWithId($id);
		   $all_languages = explode("+",$id);
	       $languages  = CepLanguages::where("lang_status",1)->whereIn("lang_code",$all_languages)->get();
	       $keywords = CepKeywords::where("kw_status",1)->get();
	       $keyword_translations = CepKeywordTranslations::where("kwtrans_status",1)->get();	
               $words_dictionary = array();
	       foreach($keyword_translations as $kwt){
		   		$words_dictionary[$kwt->kwtrans_keyword_id][$kwt->kwtrans_language_code] = $kwt->kwtrans_word;	
            }

            $selectLang = " <select class='lang_select form-control pull-right'>";
            foreach(CepLanguages::where("lang_status",1)->get() as $lang){
            	if($lang->lang_code == "en")
            		$selectLang .= "<option value=''>Select Language</option>";
            	else
            		$selectLang .= "<option value='".$lang->lang_id."'>".$lang->lang_name."(".$lang->lang_code.")"."</option>";
            }
            	$selectLang .= "</select>";

            //echo $selectLang; exit;	
       
	       return view('words_dictionary.show', compact('languages','keywords','words_dictionary','selectLang'));
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
              echo $id;
	
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
	}

	public function langCodeWithId($id)
	{
		$lang = CepLanguages::where("lang_id",$id)->select('lang_code')->first();
		return $lang->lang_code;
	}
}
