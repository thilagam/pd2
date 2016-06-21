<?php namespace App\Http\Middleware;

use Closure;
use View;

use App\CepLanguages;
use App\CepBreadcrumbs;
use App\CepEmailMessages;
//use App\Keywords;
//use App\KeywordTranslatiion;
//use App\Modules;
use DB;
use Request;
use Cookie;
use Auth;
use App\User;
use App\CepModules;
use App\CepAttachmentFiles;
use App\CepModels\Specification\CepSpecificationGenerals;
use App\CepModels\Specification\CepSpecificationProducts;
use App\Libraries\ProductHelper;
use Crypt;


class GlobalVariables {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		$specification_data = array();
		$global_data = array();
		$dictionary = array();
		/* Code irrespective of login */
		$global_data['configs'] = $this->configVariables();
		$default_languages;
		if(empty($default_languages)){
			$default_languages= (Cookie::get('DEFAULT_LANGUAGE_CODE_COOKIE')) ? Cookie::get('DEFAULT_LANGUAGE_CODE_COOKIE') : $global_data['configs']['default_language'];
		}
		$global_data['default_languages_value_4_view'] = $default_languages;
		/* Check login */


		if (Auth::guest())
		{
			/* Login Page Processings */
        	$moduleArr=array('login','error');
			$query = DB::table('cep_modules');
			$i=1;
			foreach ($moduleArr as $key => $value)
			{
				if($i==1){
					$query->where('mod_name','=', $value);
				}
				else
				{
					$query->orwhere('mod_name','=', $value);
				}
				$i++;
			}
			$module=$query->select('mod_id')->get();
			$moduleArr=array();
			foreach ($module as $key => $value)
			{
				$moduleArr[]=$value->mod_id;
			}
			//$module =  DB::table('cep_modules')->where('mod_url','=','login')->select('mod_id')->first();

			$global_data['dictionary'] = $this->languageSpecificText($moduleArr,$default_languages);
		}else{

			$global_data['counts']=$this->appCounts();
			$global_data['tn_breadcrumb'] = $this->breadcrumbVariables();
			$global_data['tn_messages'] = $this->fetchLastestEmail();
			/* User Plus Info */
			$default_languages_arr = DB::table('cep_user_plus')->where('up_user_id',Auth::id())->select('up_initial','up_default_language','up_profile_image','up_first_name','up_last_name','up_designation','up_company_name')->get();
			$default_languages="";
			$user_profile_image="";
			$userPlusInfo='';

			foreach ($default_languages_arr as $key => $value)
			{
				$default_languages =  $value->up_default_language;
				$user_profile_image =  $value->up_profile_image;
				$userPlusInfo=$value;
			}

			$global_data['user_profile_image'] = $user_profile_image;
        	$global_data['userPlusInfo'] = $userPlusInfo;

        	/* Later send module array to get keywords instead of adding static values in array down */
        	//$moduleArr=array('login','base','user','client','product','appointment','words_dictionary','permissions','group','pages','mailbox','home','config','breadcrumb','module','email_template','country','language','keyword','Keyword_translation','Activity_types','Activity_template','Group_permission','Permission','User_permission');

        	$module_call = $this->specificModule(Request::path()); //Specific languages Text as per modules
        	$moduleArr=array('base','pages','error','activity_main',$module_call);

        	//print_r($moduleArr);

			$query = DB::table('cep_modules');
			$i=1;
			foreach ($moduleArr as $key => $value)
			{
				if($i==1){
					$query->where('mod_name','=', $value);
				}
				else
				{
					$query->orwhere('mod_name','=', $value);
				}
				$i++;
			}
			$module=$query->select('mod_id')->get();
			$moduleArr=array();
			foreach ($module as $key => $value)
			{
				$moduleArr[]=$value->mod_id;
			}
			//echo "<pre>"; print_r($moduleArr);

			//($default_languages);
			$global_data['dictionary'] = $this->languageSpecificText($moduleArr,$default_languages);
			$global_data['products_per_user'] = $this->productsPerUser();
			$global_data['globalCounts'] = $this->appCounts();

			//echo "<pre>"; print_r($global_data['dictionary']);
		}


 		/* Share data to view & Controller with variable */
		$request->attributes->add([
		    'configs' => (object) $global_data['configs'],
		    'dictionary' => (object) $global_data['dictionary']
		]);

		$global_data['tn_languages'] = CepLanguages::where('lang_status',1)->get();
		$global_data['tn_crud'] = DB::table('cep_crud')
															->where('crud_status',1)
															->select('crud_name','crud_url')
															->orderBy('crud_name')
															->get();
		//print_r ($global_data['tn_crud']);


		$global_data['rsb_specification'] = $this->getSpecifications($default_languages);

		$global_data['item_list'] = $this->globalItems($global_data['configs']['item_list']);

		//echo "<pre>"; print_r($global_data['item_list']); exit;
    if(strstr(Request::path(), "product/")){
				$this->ftpImageNameToFile(preg_replace("/[^0-9]/","",Request::path()));
		}

        View::share($global_data);

		return $next($request);
	}

	/**
	 * Handle Item as per client selected
	 *
	 * @param  $list
	 * @return Array with all list items
	 */
		public function globalItems($list)
		{
			$itemArray = explode(", ",$list);
			$itemArrayNew = array(''=>'SELECT-ITEM');
			foreach($itemArray as $ia){
				$expld = explode("_",$ia);
				$itemArrayNew[$ia]  = strtoupper($expld[1]);
			}
			return $itemArrayNew;
		}

		/**
		 * Handle Language as per user selected
		 *
		 * @param  $module, $default_language as EN
		 * @return Associate Array with their translations
		 */
    public function languageSpecificText($module,$default_languages="en")
    {
    	//DB::enableQueryLog();
    	//echo "<pre>"; print_r($module);exit;
		$query=DB::table('cep_keywords')
			->leftJoin('cep_keyword_translations', function($join) use ($default_languages)
		        		 	{
		            			$join->on('cep_keywords.kw_id', '=', 'cep_keyword_translations.kwtrans_keyword_id')
		                 		->where('cep_keyword_translations.kwtrans_language_code', '=', $default_languages);
		        			}
	        			)
    		->leftJoin('cep_modules','cep_modules.mod_id','=','cep_keywords.kw_module_id');
    	$i=1;
        foreach ($module as $key => $value)
        {
        	if($i==1)
        	{
        		$query->orwhere('cep_keywords.kw_module_id','=',$value);
        	}else
        	{
        		$query->orwhere('cep_keywords.kw_module_id','=',$value);
        	}
        }

		$words=$query->select('cep_keywords.kw_name', 'cep_keyword_translations.kwtrans_word')->get();
		$words_refined_array =  $this->convertSpecificTextArray($words);
		//$queries = DB::getQueryLog();
		//$last_query = end($queries);
		//echo $last_query;
		//echo "<pre>"; print_r($words_refined_array);exit;
		//$words_refined_array = (object) $words_refined_array;
		return $words_refined_array;
    }

		/**
		 * Handle Words with Specific Text and Translation with BREADCRUMB
		 *
		 * @param  $words default will be english
		 * @return Associate Array with their translations
		 */
	public function convertSpecificTextArray($words)
	{
	    //print_r ($words);
	    $modified_words_array = array();
	    foreach($words as $word){
                if(!empty($word->kwtrans_word)){
                    $modified_words_array[$word->kw_name] = $word->kwtrans_word;

                    //Replace CL_NAME PRD_NAME FOR PRODUCT BREADCRUMB VALUES
                    if(strstr(Request::path(), "product/")){

                    	if(!empty(Request::segment(3)) && !is_numeric(Request::segment(3)))
                    		$product_id = Crypt::decrypt(Request::segment(3)); // writer secure URL's
                    	else
                    		$product_id = preg_replace("/[^0-9]/","",Request::path()); // for product dashboard page



                    	$this->productHelper = new ProductHelper;
                    	$value = $this->productHelper->checkProductExists($product_id);

                    	$modified_words_array[$word->kw_name] = str_replace("CL_NAME", $value->company, $modified_words_array[$word->kw_name]);
                    	$modified_words_array[$word->kw_name] = str_replace("PRD_NAME", $value->name, $modified_words_array[$word->kw_name]);
                    }
                    // CLOSE NAME ASSIGN

                }
                else
                   $modified_words_array[$word->kw_name] = $word->kw_name;
	    }
            return $modified_words_array;
	}

	/**
	* Handle & get all Config Variables
	*
	* @return Associate Array with their config and there values
	*/

	public function configVariables()
	{
            $configs = DB::table('cep_configs')->where('conf_status','=','1')->get();
            foreach($configs as $config){
                   $modified_configs_array[$config->conf_name] = $config->conf_value;
            }
            return $modified_configs_array;
	}

	/* NOT using Below function */
	public function breadcrumbVariables()
	{

		$url_variables = Request::path();
		$url_variables = preg_replace('/\d+/','DD',$url_variables);
		$breadcrum_variables = CepBreadcrumbs::with('modules')->where('breadcrumb_url','=',$url_variables)->first();

		//echo "<pre>"; print_r($breadcrum_variables); exit;

		return $breadcrum_variables;
	}


	/**
	* Count all the client
	*
	* @return Associate Array count of clients
	*/

	function appCounts(){
		 $counts=array();
		 $counts['clientCount'] = DB::table('cep_product_users')
                    ->select(
                    		 'id as client_id'
                            )
                    ->leftjoin('users', 'puser_user_id', '=', 'id')
                  	->leftjoin('cep_groups', 'cep_groups.group_id', '=', 'puser_group_id')
                    ->where('group_code', '=', 'CL')
                    ->where('users.status', '=', 1)

                    ->groupBy('puser_user_id')
                    ->count();
                    //echo "<pre>"; print_r($clients);exit;

        return $counts;
	}

	/**
	* Get all the products for login User
	*
	* @return Associate Array to show values in left sidebar
	*/
	public function productsPerUser(){
		$user = User::with('groups')->find(Auth::id());
		//echo "<pre>"; print_r($user);exit;
		if((strcmp($user->groups->group_code,"SA") == 0 || strcmp($user->groups->group_code,'DEV') == 0)){
			$product = DB::table('users')
				       ->select('id','up_company_name','prod_id','prod_name','item_id','item_name','item_url','item_status')
				       ->leftjoin('cep_user_plus','up_user_id','=','id')
				       ->leftjoin('cep_groups','cep_groups.group_id','=','users.group_id')
				       ->leftjoin('cep_product_users','puser_user_id','=','id')
				       ->leftjoin('cep_products','puser_product_id','=','prod_id')
				       ->leftjoin('cep_items','item_product_id','=','prod_id')
				       ->where('group_code',"CL")
				       ->orderBy('up_company_name','ASC')
				       ->get();
		}else{
               	$id = Auth::id();
		       	$product = DB::table('cep_product_users')
				  ->select('up_user_id as id','up_company_name','prod_id','prod_name','item_id','item_name','item_url','item_status')
			          ->leftjoin('cep_groups', 'cep_groups.group_id', '=', 'cep_product_users.puser_group_id')
			          ->leftjoin('cep_user_plus', 'cep_user_plus.up_user_id', '=', 'cep_product_users.puser_user_id')
			          ->leftjoin('cep_products', 'cep_products.prod_id', '=', 'cep_product_users.puser_product_id')
			          ->leftjoin('cep_items','item_product_id','=','prod_id')
	    		      ->whereIn('puser_product_id', function($query) use ($id)
	    		          {
	       			        $query->select('puser_product_id')
	                                      ->from('cep_product_users')
	                                      ->whereRaw('cep_product_users.puser_user_id = '.$id)
	                                      ->whereRaw('cep_product_users.puser_status = 1')
	                                      ->groupBy('puser_product_id');
	                          })
	    		       ->where('prod_status',1)
	                          ->groupBy('item_id','puser_product_id')
														->orderBy('up_company_name','ASC')
	                          ->get();

		}
       // echo "<pre>"; print_r($product);exit;
//		print_r ($product);
		$clientList=array();
		$prodList=array();
		$itemList= array();
		$all_products = "";
		foreach ($product as $key => $value) {
			$clientList[$value->id]['name']=$value->up_company_name;
			$clientList[$value->id]['id']=$value->id;
			if($value->prod_id!=''){
				$clientList[$value->id]['products'][$value->prod_id]['id']=$value->prod_id;
				$clientList[$value->id]['products'][$value->prod_id]['name']=$value->prod_name;
			}
			if($value->item_id!='' && $value->item_status==1){
				$clientList[$value->id]['products'][$value->prod_id]['items'][$value->item_id]['id']=$value->item_id;
				$clientList[$value->id]['products'][$value->prod_id]['items'][$value->item_id]['name']=$value->item_name;
				$clientList[$value->id]['products'][$value->prod_id]['items'][$value->item_id]['url']=$value->item_url;
			}

			$all_products.=$value->prod_id.",";
			$clientList[$value->id]['all'] = $all_products;
			if($key < count($product)-1 && $clientList[$value->id]['id'] != $product[$key+1]->id)
				$all_products="";
		}

		 //echo "<pre>"; print_r($clientList);exit;

		return $clientList;
	}

	/**
	* handle request and fetch latest messages as per login user
	*
	* @return Associate Array with all message and count
	*/
	public function fetchLastestEmail(){
			$tn_messages = array();
			$tn_messages['msg'] = CepEmailMessages::where('em_to',Auth::id())
												->skip(0)->take(3)
												->orderBy('em_create_date','desc')
												 ->select(DB::raw('*,DATE_FORMAT(em_create_date,"%a,%d %M %Y %h:%i %p") as em_dt'))
												->get();

			$tn_messages['msg_count'] = CepEmailMessages::where('em_to',Auth::id())
												->where('em_read_status',0)
												->count();
			//print_r ($tn_messages); exit;
			return $tn_messages;
	}

	/**
	 * get module name based on url
	 *
	 * @param  int $path :- module page url
	 * @return string $modulename :- name of module as per module.
	 */

	public function specificModule($path){
			$path_l = explode("/",$path);
			if(strpos($path,"/") !== 0 && $path_l[0] != 'auth' && $path_l[0] != 'accessDenied' && $path_l[0] !='test'){
				$query = CepModules::where("mod_url",$path_l[0])->select('mod_name');
				if($query->count() > 0){
					$mod = $query->first();
					if(strcmp($mod->mod_name, 'Edit_profile') == 0)
						return 'Client';
					else if(strcmp($mod->mod_name, 'Item') == 0)
						return 'Product';
					else
						return $mod->mod_name;
					//return ($mod->mod_name == 'Edit_profile') ? 'Client' : ($mod->mod_name == 'Item') ? 'Product' : $mod->mod_name;
				}else{
					return 0;
				}
			}else{
				return "login";
			}
	}

	/**
	 * get Help text based on languages and url.
	 *
	 * @param  int $default_languages :- default language selected by user (if no english)
	 * @return array $specification_data contain page help text based on url and languages
	 */

	public function getSpecifications($default_languages){

		$specification_data = array();

		$lang_array = array($default_languages,"en");
		$lang_array_i = "'".implode("','", $lang_array)."'";

		$specification_data['general'] = CepSpecificationGenerals::
											where("specgen_url",preg_replace('/\d+/','DD',Request::path()))
											->where("specgen_status",1)
											->whereIn("specgen_language_code",$lang_array)
											->orderBy(DB::raw("field(`specgen_language_code`,$lang_array_i)"))
											->first();

		$specification_data['product'] =  CepSpecificationProducts::where("specprod_url",Request::path())
											->where("specprod_status",1)
											->whereIn("specprod_language_code",$lang_array)
											->orderBy(DB::raw("field(`specprod_language_code`,$lang_array_i)"))
											->first();

		//select * from `cep_specification_generals` where `specgen_url` = "general-specifications"  and `specgen_status` = 1 and `specgen_language_code` in ("fr","en") ORDER BY FIELD(`specgen_language_code`, "fr","en") limit 1

		//echo "<pre>"; print_r ($specification_data['general']); exit;
		if($specification_data['product']['specprod_attachment_id'] > 0 ){
			$specification_data['product']['attachments'] = CepAttachmentFiles::where('attfiles_attachment_id',$specification_data['product']['specprod_attachment_id'])->get();
		}

        //echo "<pre>"; print_r ($specification_data['product']); exit;
			 return ($specification_data);

	}

	/**
	* automatically create files containing array of all the images
	*	@param  $product_id based on client product like Caroll flex
	*/

	public function ftpImageNameToFile($product_id)
	{
		  $path = public_path()."/uploads/products/";
			exec("python ".base_path()."/app/Services/ftp_json.py ".$product_id." ".$path);
	}

}
