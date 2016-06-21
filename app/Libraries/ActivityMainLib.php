<?php namespace App\Libraries;

use Auth;
use App\CepActivityMains;
use App\CepActivityTemplates;
use App\CepUserPlus;
use DB;
use Carbon\Carbon;
use App\CepConfigs;


class ActivityMainLib{

	public function __construct(){
	}
	
	 /**
         * Function getActivity
         *
         * @param $email_parameters array contain email parameters
         * @return $template_code->etemp_template_code contain template code of perticular id
         */
	public function getActivity($client_id,$prod_id,$current_id=0){
		//echo $prod_id;

		//pagination values
		$configs = CepConfigs::where('conf_name','activity_default_pagination_value')->select('conf_value')->first();

		$user = CepUserPlus::where('up_user_id',Auth::id())->select('up_default_language')->first();
		$lang = $user['up_default_language'];
		$query = CepActivityMains::leftjoin('cep_activity_templates','act_template_id','=','actmp_id')
					       ->leftjoin('cep_activity_templates_plus','actmp_id','=','actmpplus_template_id')
					       ->leftjoin('cep_activity_types','acttype_id','=','actmpplus_type')
					       ->leftjoin('cep_products','prod_id','=','act_product_id')
					       ->leftjoin('cep_items','item_id','=','act_item_id')
					       ->leftjoin('cep_user_plus','up_id','=','act_by')	
//					       ->where('act_client_id','=',$client_id)
					       ->whereRaw("actmpplus_language_code = (SELECT if(EXISTS(SELECT * FROM cep_activity_templates_plus WHERE actmpplus_template_id = act_template_id AND actmpplus_language_code = '$lang'), '$lang', 'en' ))");

		if($current_id > 0)			       
			$query = $query->where('act_id','<',$current_id);
				       
			
		if($prod_id > 0)
			$query = $query->where("prod_id",$prod_id);
		else
			$query = $query->where('act_by','=',$client_id);

				
		$activities = $query->select(DB::raw('*,DATE_FORMAT(act_datetime,"%a,%d %M %Y %h:%i %p") as act_dt'))->orderBy('act_datetime','desc')->take($configs->conf_value)->get();
	        //echo "<pre>"; print_r ($activities); exit;	
		foreach($activities as $k=>$act){
			if(!empty($act['act_variables'])){
			foreach(json_decode($act['act_variables']) as $key=>$emvar)
				$activities[$k]['actmpplus_template'] = str_replace($key,$emvar,$activities[$k]['actmpplus_template']);
			}
		}
			
		return $activities;
	}


         /**
         * Function postActivity
         *
         * @param $activitess array contain fields 
         * @return true
         */
        public function postActivity($activities){
        	$this->activityFileLogs($activities);
			return (CepActivityMains::create($activities) ? true : false);			
        }

         /**
         * Function activityFileLogs
         *
         * @param $activites array contain fields 
		 * Note :- 	It will save data in text based files with json format with {filename} inside uploads/activity/
		 * filename :- "w"."current week by year"."d"."year+month" 
         */ 

         public function activityFileLogs($activites){

         		$activites['act_datetime'] = $dt = Carbon::now();
         		$filename = public_path()."/uploads/activity/"."w".$dt->weekOfYear."d".$dt->year.$dt->month;	
         		$myfile = fopen($filename, "a+") or die("Unable to open file!");
         		$activites['act_template_id'] = CepActivityTemplates::where("actmp_id",$activites['act_template_id'])->select('actmp_id','actmp_name','actmp_description')->first();
				fwrite($myfile, json_encode(($activites)));
				fclose($myfile);

         }

}
