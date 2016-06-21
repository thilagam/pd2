<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Support\Collection;

/* Models */		
use App\User;
use App\CepUserPlus;
use App\CepGroups;
use App\CepCountry;
use App\CepProducts;
use App\CepProductUsers;
use App\CepProductFtp;
use App\CepProductConfigurations;
use App\CepProductMailingList;
use App\CepItems;
use App\CepUploads;
use App\CepDownloads;

/* FACADES */		
use DB;
use Validator;
use Auth;
use Input;  
use Request;
use Crypt;
use Config;
use FTP;
use Log;
use File;
use Storage;

/* Services */		
use App\Services\UploadsManager;

/* Libraries */		
use App\Libraries\FileManager; 
use App\Libraries\CheckAccessLib;
use App\Libraries\ProductHelper;
use App\Libraries\EMailer;
use App\Libraries\ActivityMainLib;

class ProductController extends Controller {


	public $permissions;
	public $configs;
	public $dictionary;

	private $manager;
    private $activityObject;
    private $checkaccess;
    private $productHelper;
    protected $emailActivity;
    protected $customactivity;


	 /**
     * Instantiate a new UserController instance.
     */
    public function __construct(\Illuminate\Http\Request $request)
    {	
    	$this->middleware('auth');
    	
    	$this->permit=$request->attributes->get('permit');
    	$this->configs=$request->attributes->get('configs');
    	$this->dictionary=$request->attributes->get('dictionary');

    	$this->manager=new UploadsManager;
    	$this->activityObject = new ActivityMainLib;
    	$this->checkaccess = new CheckAccessLib;
    	$this->productHelper = new ProductHelper;

    	$this->emailActivity = new EMailer;
        $this->customactivity = new ActivityMainLib;
    	
    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		/* Get Clients to list them  */
		$products = DB::table('cep_products')
                    ->select('prod_id as id' ,
                    		 'id as client_id' ,
                    		 'prod_name as name',
                             'up_company_name as company', 
                             'cep_products.created_at as create_date'
                            )
                    ->leftjoin('cep_product_users', 'puser_product_id', '=', 'prod_id')
                    ->leftjoin('users', 'puser_user_id', '=', 'id')
                  	->leftjoin('cep_user_plus', 'up_user_id', '=', 'puser_user_id')
                  	->leftjoin('cep_groups', 'cep_groups.group_id', '=', 'puser_group_id')
                    ->where('group_code', '=', 'CL')
                    ->where('users.status', '=', 1)
                    
                 	->orderBy('up_company_name', 'asc')
                    ->groupBy('puser_product_id')
                    ->get();
        return view('product.list',compact('products'));		
        //echo "<pre>"; print_r($products);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	

         if(!$this->checkaccess->productAccessCheck($id))
         		return redirect('accessDenied');
	

		$variablesArray=array();
		/* Get Product details   */
		$product = DB::table('cep_products')
                    ->select('prod_id as id' ,
                    		 'id as client_id' ,
                    		 'prod_name as name',
                             'up_company_name as company', 
                             'prod_description as description',
                             'cep_products.created_at as create_date',
                             'prod_revert_time',
                             'prod_status'
                            )
                    ->leftjoin('cep_product_users', 'puser_product_id', '=', 'prod_id')
                    ->leftjoin('users', 'puser_user_id', '=', 'id')
                  	->leftjoin('cep_user_plus', 'up_user_id', '=', 'puser_user_id')
                    ->where('users.status', '=', 1)
                    ->where('prod_id','=',$id)
                    ->first();
		/* Get Produt Users */		                    
        $productUsersArray=CepProductUsers::with('user','userPlus','group')
        							   ->where('puser_product_id','=',$id)
        							   ->get()
        							   ->toArray();
		//echo "<pre>"; print_r($productUsersArray);exit;        							   
		/* Segregate Users */		        							  
  		$productUsers=array('admin'=>'','admin_id'=>'','incharge'=>'','incharge_id'=>'','client'=>'','bousers'=>array(),'clientManagerId'=>'');
  		$boUsers=array();
		foreach ($productUsersArray as $key => $value) {
			/* Get first name & last name Or if not present get Username */		
			$name='';
			if($value['user_plus']['up_first_name']=='' && $value['user_plus']['up_last_name']=='')
   			{
   				$name=$value['user']['name'];
   			}
   			else
   			{
   				$name=$value['user_plus']['up_first_name']." ".$value['user_plus']['up_last_name'];
   			}
   			/* Get Client name */		
	   		if($value['group']['group_code']=='CL')
	   		{	
	   			$productUsers['client']=$name;
	   		}
	   		/* Get Client name */		
	   		if($value['group']['group_code']=='PA')
	   		{	
	   			$productUsers['admin']=$name;
	   			$productUsers['admin_id']=$value['user']['id'];
	   		}
	   		/* Get Client Manager */
	   		if($value['group']['group_code']=='CM')
	   		{	
	   			$productUsers['clientManager']=$name;
	   			$productUsers['clientManagerId']=$value['user']['id'];
	   		}		
	   		/* Get Incharge name and Bo user list */		
	   		if($value['group']['group_code']=='BO')
	   		{
	   			if($value['puser_incharge']){
	   				$productUsers['incharge']=$name;
	   				$productUsers['incharge_id']=$value['user']['id'];
	   			}else{
	   				$boUsers[$value['user']['id']]=$name;
	   			}
	   		}
	   		$mailingList=array();
	   	} 
	   	$productUsers['bousers']=$boUsers;    
	   	$productUsers=(object) $productUsers; 
	   	//echo "<pre>"; print_r($productUsers);exit;
	   	$alphaRange=array_combine(range('1','26'),range('A','Z'));

	   	/* Only for permissions Config of Super Admin and Developer */		
	   	if($this->permit->module_product_config_devsa)
	   	{
		   	/* Product Configurations Data and Processings for SA AND DEV  */		 							   
		   	
		   	$allBoUsers= DB::table('users')
	                    ->select('id' ,
	                    		 'group_code as group' ,
	                    		 'up_first_name as first_name',
	                             'up_last_name as last_name',
	                             'name'
	                             
	                            )
	                    ->leftjoin('cep_groups', 'cep_groups.group_id', '=', 'users.group_id')
	                  	->leftjoin('cep_user_plus', 'up_user_id', '=', 'id')
	                    ->where('users.status', '=', 1)
	                    ->where('group_code','=','BO')
	                    ->get();
	        $bouserData=array('0'=>'');
	       // echo "<pre>"; print_r($allBoUsers);
	       // / $paData=array('0'=>'');
			foreach ($allBoUsers as $key => $value) {
				if($value->group='BO'){
					$bouserData[$value->id]=($value->first_name!='') ? ucfirst($value->first_name)." ".ucfirst($value->last_name): $value->name ;
				}
				if($value->group=='PA'){
					$paData[$value->id]=($value->first_name!='') ? ucfirst($value->first_name)." ".ucfirst($value->last_name): $value->name ;	
				}
			}
			//echo "<pre>"; print_r($bouserData);exit;
			$allPAUsers= DB::table('users')
	                    ->select('id' ,
	                    		 'group_code as group' ,
	                    		 'up_first_name as first_name',
	                             'up_last_name as last_name',
	                             'name'
	                             
	                            )
	                    ->leftjoin('cep_groups', 'cep_groups.group_id', '=', 'users.group_id')
	                  	->leftjoin('cep_user_plus', 'up_user_id', '=', 'id')
	                    ->where('users.status', '=', 1)
	                    ->where('group_code','=','PA')
	                    ->get();
		   	$paData=array('0'=>'');
			foreach ($allPAUsers as $key => $value) {
				
				if($value->group=='PA'){
					$paData[$value->id]=($value->first_name!='') ? ucfirst($value->first_name)." ".ucfirst($value->last_name): $value->name ;	
				}
			}
			/* Config Data */
			$prodConfigs=array();		
			$prodConfigs['ftp']=CepProductFtp::where('ftp_product_id','=',$id)->first();
			
			$prodConfigs['pdn']=CepProductConfigurations::where('pconf_type','=','pdn')
										 ->where('pconf_product_id','=',$id)
										 ->first();
			$prodConfigs['ref']=CepProductConfigurations::where('pconf_type','=','ref')
										 ->where('pconf_product_id','=',$id)
										 ->first();									

			//echo "<pre>"; print_r($prodConfigs);exit;

			$variablesArray[]='bouserData';
			$variablesArray[]='paData';
			$variablesArray[]='prodConfigs';	
			
		} 
		if($this->permit->module_product_config_client)
	   	{
	   		
	   		$mailingList=array();
	   		$index=0;

	   		$cmUsers=User::with('userPlus')->where('user_parent_id','=',$product->client_id)->get();
	   		$cmusersArray = array('0'=>'');
	   		if(!is_null($cmUsers))
	   		{
		   		foreach ($cmUsers as $key => $value) {
		   			if($value['user_plus']['up_first_name']=='' && $value['user_plus']['up_last_name']=='' ){
		   				$cmusersArray [$value->id]=$value->name;
		   			}else{
		   				$cmusersArray [$value->id]=ucfirst($value['user_plus']['up_first_name'])." ".ucfirst($value['user_plus']['up_last_name']);
		   			}		
		   		}
	   		}
	   		$variablesArray[]='cmusersArray';
	   		//echo "<pre>"; print_r($cmusersArray);exit;

	   		$variablesArray[]='index';
	   		
	   		
		}
		
		if($this->permit->module_product_config_bo)
	   	{	
	   		/* Get All BO Users except incharge */		
	   		$allBoUsers= DB::table('users')
	                    ->select('id' ,
	                    		 'group_code as group' ,
	                    		 'up_first_name as first_name',
	                             'up_last_name as last_name',
	                             'name'
	                             
	                            )
	                    ->leftjoin('cep_groups', 'cep_groups.group_id', '=', 'users.group_id')
	                  	->leftjoin('cep_user_plus', 'up_user_id', '=', 'id')
	                    ->where('users.status', '=', 1)
	                    ->where('users.id','!=',$productUsers->incharge_id)
	                    ->where('group_code','=','BO')
	                    ->get();
	        $cBouserData=array('0'=>'');
	       // echo "<pre>"; print_r($allBoUsers);
	       // / $paData=array('0'=>'');
			foreach ($allBoUsers as $key => $value) {
				if($value->group='BO'){
					$cBouserData[$value->id]=($value->first_name!='') ? ucfirst($value->first_name)." ".ucfirst($value->last_name): $value->name ;
				}				
			}
			$boindex=1;
			$variablesArray[]='cBouserData';
			$variablesArray[]='boindex';
		}
		/* Get Mailing List */		
		$mailingList=CepProductMailingList::where('ml_product_id','=',$id)->get();

		$variablesArray[]='product';
		$variablesArray[]='productUsers';
		$variablesArray[]='alphaRange';
		$variablesArray[]='mailingList';
		

		if($this->permit->module_product_items){
				$product_items = CepItems::leftjoin('cep_product_configurations','item_id','=','pconf_item_id')
						->where('item_product_id',$id)
						->where('item_status',1)
						->get();
				$variablesArray[]='product_items';		
        }

        if($this->permit->module_product_activity){
                $activity = $this->activityObject->getActivity(Auth::id(),$id);
                $variablesArray[]='activity';
        }	

        $allProductItems = CepItems::where('item_product_id',$id)->where('item_status',1)->get();
        $variablesArray[]= 'allProductItems';

        
		//echo $product_items;				
		/* Add Veriables based on satisfied conditions  */			                
		return view('product.show',compact($variablesArray));
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

	/**
	 * Function configs
	 * Function used for storing FTP and Config data 
	 * @param
	 * @return
	 */		
	public function configs($id)
	{	
		$input = Input::all();
		$prod=CepProducts::where('prod_id','=',$id)->first();
		//echo "<pre>"; print_r($_FILES);exit;
		if(is_null($prod)){
			$error="Product not presnt";
			Log::error($error);
			return redirect('product');	
		}

		/* Get Client Info */		
		$client= DB::table('cep_products')
                    ->select('id' ,
                    		 'prod_id'
                    		)
                    ->leftjoin('cep_product_users', 'puser_product_id', '=', 'prod_id')
                    ->leftjoin('users', 'puser_user_id', '=', 'id')
                    ->leftjoin('cep_groups', 'users.group_id', '=', 'cep_groups.group_id')
                  	->where('users.status', '=', 1)
                  	->where('group_code', '=', 'CL')
                    ->where('puser_product_id','=',$id)
                    ->first();
        /* WORKING */		            

		/* UPDATE FTP information */		
		$ftpInfo = Request::only('ftp','host','username','password','port','group_id');
   		$validateFtp = Validator::make($ftpInfo ,[
                    'ftp' => 'required',
                    'host' => 'sometimes',
                    'username' => 'sometimes',
	    			'password' => 'sometimes',
	    			'port'=>'sometimes'
         ]);
   		if($validateFtp->fails())
        {
                return redirect()->back()->withErrors($validateFtp->errors());
        }
        if($ftpInfo['ftp']==1)
        {
	   		$ftpData=CepProductFtp::where('ftp_product_id','=',$id)->first();
	   		if(is_null($ftpData)){
	   			$ftp=array(
		   			'ftp_product_id'=>$id,
		   			'ftp_host'=>$input['host'],
		   			'ftp_username'=>$input['username'],
		   			'ftp_port'=>$input['port'],
		   			'ftp_path'=>$this->configs->uploads_products_path.$id."/ftp",
		   			'ftp_created_by'=>Auth::id(),
		   			'ftp_status'=>$input['ftp']
				);
				if($input['password']!='')
				{
					$ftp['ftp_password']=Crypt::encrypt($input['password']);
				}
				$ftp = CepProductFtp::create($ftp);

				/* Create FTP Item */		
				$ftp_item=array(
					'item_product_id'=>$id,
					'item_name'=>'link_ftp_references',
					'item_info'=>'ftp view',
					'item_url'=>'product/ftp/'.$id
					);
				$ftpItem = CepItems::Create($ftp_item);

				/* Create FTP folder in product folder */		
				$this->manager->createDirectory($this->configs->uploads_products_path.$id."/ftp");
                chmod(public_path().$this->configs->uploads_path."/".$this->configs->uploads_products_path.$id."/ftp", 0777);
             	

	   		}else{
	   			
	   			$ftpData->ftp_product_id=$id;
	   			$ftpData->ftp_host=$input['host'];
	   			$ftpData->ftp_username=$input['username'];
	   			if($input['password']!='')
				{
	   				$ftpData->ftp_password=Crypt::encrypt($input['password']);
	   			}
	   			$ftpData->ftp_port=$input['port'];
	   			$ftpData->ftp_updated_by=Auth::id();
	   			$ftpData->ftp_status=$input['ftp'];
	   			
	   			$ftpData->save();
	   		}
   		}else{
   			$ftpData=CepProductFtp::where('ftp_product_id','=',$id)->first();
			

			if(!is_null($ftpData)){
				$ftpData->ftp_status=0;
				$ftpData->save();

				$ftpItem = CepItems::where('item_product_id','=',$id)
									 ->where('item_url','=','product/ftp/'.$id)->first();
				if(!is_null($ftpItem)){
					$ftpItem->item_status=0;
					$ftpItem->save();
				}
			}
   		}
   		/* PDN Update or Create */

   		$pdnInfo = Request::only('pdnradio','path','pdn_ref');
   		$validatePdn = Validator::make($pdnInfo,[
                    'pdnradio' => 'required',
                    'path'=>'sometimes',
                    'pdn_ref' => 'sometimes'                
         ]);

   		if($validatePdn->fails())
        {
                return redirect()->back()->withErrors($validatePdn->errors());
        }
         

        if(isset($pdnInfo['pdnradio']) && $pdnInfo['pdnradio']==1){	
			$pdnData=CepProductConfigurations::where('pconf_product_id','=',$id)
									->where('pconf_type','=','pdn')
									->first();
			

			if(is_null($pdnData)){
				$pdn=array(
						'pconf_product_id'=>$id,
						'pconf_type'=>'pdn',
						'pconf_path'=>$pdnInfo['path'],
						'pconf_template'=>'',
						'pconf_reference_id'=>$pdnInfo['pdn_ref'],
						'pconf_status'=>$pdnInfo['pdnradio'],
						'pconf_created_by'=>Auth::id()
					);
				$pdnConfData=CepProductConfigurations::create($pdn);

				/* Create PDN Item */		
				$pdn_item=array(
					'item_product_id'=>$id,
					'item_name'=>'link_pdn',
					'item_info'=>'pdn view',
					'item_url'=>'product/pdn/'.$id
					);
				$pdnItem = CepItems::Create($pdn_item);

				$pdnConfData->pconf_item_id=$pdnItem->item_id;
				$pdnConfData->save();

				/* PDN  Template */	
				$file=Input::file('pdn_file');
				$upload=array();
				if($file){
			        
			        $name=uniqid();
					$options =array ( 
				 				'name'=>$name,
				 				'type'=>'pdn_template',
								'description'=> 'pdnupload',
								'url'=> 'templates/',
								'client'=> $client->id,
								'product'=> $id,
								'item'=> $pdnItem->item_product_id 
							 );
					$FileManager=new FileManager();
					$upload=$FileManager->upload($file,$options);
					/* Update New PDN config with Template */		
					$newPdnData=CepProductConfigurations::where('pconf_product_id','=',$id)
										->where('pconf_type','=','pdn')
										->first();
					$newPdnData->pconf_template=($upload)?$upload->upload_url:'';
					$newPdnData->save();
				}
				
				/* Create PDN folder in product folder */		
				$this->manager->createDirectory($this->configs->uploads_products_path.$id."/pdn");
                chmod(public_path().$this->configs->uploads_path."/".$this->configs->uploads_products_path.$id."/pdn", 0777);
             	


			}else{


				/* PDN  Template */	
				$pdnItem = CepItems::where('item_product_id','=',$id)
									 ->where('item_url','=','product/pdn/'.$id)->first();
		        $file=Input::file('pdn_file');
		        $upload=array();
		        if($file)
		        {
			        $name=uniqid();
					$options =array ( 
				 				'name'=>$name,
				 				'type'=>'pdn_template',
								'description'=> 'pdnupload',
								'url'=> 'templates/',
								'client'=> $client->id,
								'product'=> $id,
								'item'=> $pdnItem->item_product_id 
							 );
					$FileManager=new FileManager();
					$upload=$FileManager->upload($file,$options);
					//echo "<pre>"; print_r($upload);exit;
					$pdnData->pconf_template=(!is_null($upload))?$upload->upload_url:'';
				}else{
					$upload=false;
				}
				$pdnData->pconf_product_id=$id;
				$pdnData->pconf_type='pdn';
				$pdnData->pconf_path=$pdnInfo['path'];
				$pdnData->pconf_item_id=$pdnItem->item_id;
				$pdnData->pconf_reference_id=$pdnInfo['pdn_ref'];
				$pdnData->pconf_status=$pdnInfo['pdnradio'];
				$pdnData->pconf_updated_by=Auth::id();

				$pdnData->save();

			}
		}else{
			$pdnData=CepProductConfigurations::where('pconf_product_id','=',$id)
									->where('pconf_type','=','pdn')
									->first();
			

			if(!is_null($pdnData)){
				$pdnData->pconf_status=0;
				$pdnData->save();

				$pdnItem = CepItems::where('item_product_id','=',$id)
									 ->where('item_url','=','product/pdn/'.$id)->first();
				if(!is_null($pdnItem)){
					$pdnItem->item_status=0;
					$pdnItem->save();
				}
			}

		}
		/* Ref Update or Create */		
   		$refInfo = Request::only('refradio','ref_path','ref_ref');
   		$validateRef = Validator::make($refInfo,[
                    'refradio' => 'required',
                    'ref_path'=>'sometimes',
                    'ref_ref' => 'sometimes'                
         ]);
   		if($validateRef->fails())
        {
                return redirect()->back()->withErrors($validateRef->errors());
        }
        /* Ref Template File processing */
        if(isset($refInfo['refradio']) && $refInfo['refradio']){		
			$refData=CepProductConfigurations::where('pconf_product_id','=',$id)
									->where('pconf_type','=','ref')
									->first();
			if(is_null($refData)){
				$ref=array(
						'pconf_product_id'=>$id,
						'pconf_type'=>'ref',
						'pconf_path'=>$refInfo['ref_path'],
						'pconf_template'=>'',
						'pconf_reference_id'=>$refInfo['ref_ref'],
						'pconf_status'=>$refInfo['refradio'],
						'pconf_created_by'=>Auth::id()
					);
				$pconf_data=CepProductConfigurations::create($ref);


				/* Create Ref Item */		
				$ref_item=array(
					'item_product_id'=>$id,
					'item_name'=>'link_ref',
					'item_info'=>'ref view',
					'item_url'=>'product/ref/'.$id
					);
				$refItem = CepItems::Create($ref_item);
				//echo "<pre>"; print_r($refItem);exit;
				$pconf_data->pconf_item_id=$refItem->item_id;
				$pconf_data->save();
				/* REF  Template */	
		        $file=Input::file('ref_file');
		        if($file)
		        {
			        $name=uniqid();
					$options =array ( 
				 				'name'=>$name,
				 				'type'=>'ref_template',
								'description'=> 'refupload',
								'url'=> 'templates/',
								'client'=> $client->id,
								'product'=> $id,
								'item'=> $refItem->item_product_id 
							 );
					$FileManager=new FileManager();
					$upload=$FileManager->upload($file,$options);
					/* Update New PDN config with Template */		
					$newPdnData=CepProductConfigurations::where('pconf_product_id','=',$id)
										->where('pconf_type','=','ref')
										->first();
					//echo "<pre>"; print_r($newPdnData);		exit;								
					$newPdnData->pconf_template=($upload && !empty($upload))?$upload->upload_url:'';
					$newPdnData->save();
				}
				/* Create Ref folder in product folder */		
				$this->manager->createDirectory($this->configs->uploads_products_path.$id."/ref");
                chmod(public_path().$this->configs->uploads_path."/".$this->configs->uploads_products_path.$id."/ref", 0777);
             

			}else{
				/* REF Template */	
				$ref_item = CepItems::where('item_product_id','=',$id)
									 ->where('item_url','=','product/ref/'.$id)->first();
		        $file=Input::file('ref_file');
		        $upload=array();
		        if($file)
		        {
		        $name=uniqid();
				$options =array ( 
			 				'name'=>$name,
			 				'type'=>'ref_template',
							'description'=> 'refupload',
							'url'=> 'templates/',
							'client'=> $client->id,
							'product'=> $id,
							'item'=> $ref_item->item_product_id 
						 );
				$FileManager=new FileManager();
				$upload=$FileManager->upload($file,$options);
				$refData->pconf_template=(!is_null($upload))?$upload->upload_url:'';
				}else{
					$upload=false;
				}
				$refData->pconf_product_id=$id;
				$refData->pconf_item_id=$ref_item->item_id;
				$refData->pconf_type='ref';
				$refData->pconf_path=$refInfo['ref_path'];
				
				$refData->pconf_reference_id=$refInfo['ref_ref'];
				$refData->pconf_status=$refInfo['refradio'];
				$refData->pconf_updated_by=Auth::id();

				$refData->save();

			}
		}else{
			$refData=CepProductConfigurations::where('pconf_product_id','=',$id)
									->where('pconf_type','=','ref')
									->first();
			

			if(!is_null($refData)){
				$refData->pconf_status=0;
				$refData->save();

				$refItem = CepItems::where('item_product_id','=',$id)
									 ->where('item_url','=','product/ref/'.$id)->first();
				if(!is_null($refItem)){
					$refItem->item_status=0;
					$refItem->save();
				}
			}

		}

		/* Incharge Update */	
		if(isset($input['incharge']) && $input['incharge']!='')
		{
			$inchargeId=$input['incharge'];
			$incharge= CepProductUsers::where('puser_product_id','=',$id)
										->where('puser_incharge','=',1)
										// /->where('puser_user_id','=',$inchargeId)
										->first();
			if(is_null($incharge)){
				$productInchargeData=array(
		                                'puser_product_id'=>$id,
		                                'puser_user_id'=>$inchargeId,
		                                'puser_group_id'=>243211,
		                                'puser_incharge'=>1
		                                );
		        CepProductUsers::create($productInchargeData);
			}else{
				$incharge->puser_user_id=$inchargeId;
		        /* SAVE BOUSER INFO */        
		        $incharge->save();

			}
		}
        /* Product Admin Update */	
       
        if(isset($input['productAdmin']) && $input['productAdmin']!=''){
        	$prodAdminId=$input['productAdmin'];
			$padmin= CepProductUsers::where('puser_product_id','=',$id)
										->where('puser_group_id','=',243213)
										->first();
			if(is_null($padmin)){
				$productAdmineData=array(
	                                    'puser_product_id'=>$id,
	                                    'puser_user_id'=>$prodAdminId,
	                                    'puser_group_id'=>243213,
	                                    'puser_incharge'=>0
	                                    );
	            CepProductUsers::create($productAdmineData);
			}else{
				$padmin->puser_user_id=$prodAdminId;
	            /* SAVE BOUSER INFO */        
	            $padmin->save();
			}
		}
		/* Default Revert Time for Product */		
		if(isset($input['revert_time']) && $input['revert_time']!='')
		{
			$revert_time=$input['revert_time'];

			$prod->prod_revert_time=$revert_time;
			$prod->save();
		}

		return redirect()->back();


	}

	/**
	 * Function clientConfigs
	 *
	 * @param
	 * @return
	 */		
	public function clientConfigs($id)
	{
		$input = Input::all();
		$errors=array();
		$prod=CepProducts::where('prod_id','=',$id)->first();
		/* Check if Product is Authentic */		
		if(is_null($prod))
		{
			$error[]=$this->dictionary->msg_invalid_product;
			return redirect()->back()->withErrors($error);	
		}
		/* Validate Email Ids */		
		foreach ($input['emails'] as $key => $value) 
		{
			if(!filter_var( $value, FILTER_VALIDATE_EMAIL ))
			{
				$errors[]=$value." : ".$this->dictionary->msg_invalid_email;
			}
		}
		if(!empty($errors))
		{
        	return redirect()->back()->withErrors($errors);
    	}else
    	{	$counter=1;
    		$old=CepProductMailinglist::where('ml_product_id','=',$id)->get();
    		$oldEmails=array();
    		foreach ($old as $key => $value) {
    			$oldEmails[]=$value->ml_email;
    		}
    		$difference = array_diff($oldEmails, $input['emails']);
    		//echo "<pre>"; print_r($difference);exit;
    		foreach ($input['emails'] as $key => $value) 
    		{	
    			if($counter<=$this->configs->max_mailing_list_count)
    			{
    				//$check=CepProductMailinglist::where('ml_email','=',$value)->where('ml_product_id','=',$id)->first();
	    			if(!in_array($value,$oldEmails))
	    			{
		    			$list=array(
		    				'ml_email'=>$value,
		    				'ml_product_id'=>$id,
		    				'ml_created_by'=>Auth::id()
		    				);
		    			CepProductMailinglist::create($list);
	    			}
	    		}else{
	    			$errors[]=$this->dictionary->msg_mailing_list_overload;
	    		}
	    		$counter++;
    		}

    		foreach ($difference as $key => $value) {
    			CepProductMailinglist::where('ml_email','=',$value)
    								->where('ml_product_id','=',$id)
    								->delete();
    		}

    	}
    	/* Add Client product Manager for this Product */		
    	if($input['clientIncharge']!='')
    	{
    		$inchargeCheck=CepProductUsers::where('puser_product_id','=',$id)
										->where('puser_group_id','=',243214)
										->first();
			if(is_null($inchargeCheck)){
				$productInchargeData=array(
		                                'puser_product_id'=>$id,
		                                'puser_user_id'=>$input['clientIncharge'],
		                                'puser_group_id'=>243214,
		                                'puser_incharge'=>1
		                                );
		        CepProductUsers::create($productInchargeData);
			}else{
				$inchargeCheck->puser_user_id=$input['clientIncharge'];
		        /* SAVE BOUSER INFO */        
		        $inchargeCheck->save();

			}
    	}
    	if(!empty($errors)){
    		return redirect()->back()->withErrors($errors);
    	}else{
    		return redirect()->back()->with('success', array($this->dictionary->msg_mailing_list_success));
    	}
        //return redirect()->back();
		//echo "<pre>"; print_r($input);
	}

	/**
	 * Function boConfigs
	 *
	 * @param
	 * @return
	 */		
	public function boConfigs($id)
	{
		$input = Input::all();
		$errors=array();
		$prod=CepProducts::where('prod_id','=',$id)->first();
		/* Check if Product is Authentic */		
		if(is_null($prod))
		{
			$error[]=$this->dictionary->msg_invalid_product;
			return redirect()->back()->withErrors($error);	
		}
		//echo "<pre>"; print_r($input);
		$userArr=array();
		$productBoUsers=CepProductUsers::where('puser_product_id','=',$id)
										->where('puser_group_id','=',243211)
										->where('puser_incharge','!=',1)
										->get();
		if(!is_null($productBoUsers))
		{										
			foreach ($productBoUsers as $key => $value) 
			{
				$userArr[]=$value->puser_user_id;
			}
		}
		$difference=$userArr;
		if(isset($input['prodBoUsersId'])){
			$difference = array_diff($userArr, $input['prodBoUsersId']);
    	//echo "<pre>"; print_r($userArr );exit;
			foreach ($input['prodBoUsersId'] as $key => $value) 
			{	
				
					//$check=CepProductMailinglist::where('ml_email','=',$value)->where('ml_product_id','=',$id)->first();
					if(!in_array($value,$userArr))
					{
		    			//echo $value."<br />";
		    			$list=array(
		    				'puser_user_id'=>$value,
		    				'puser_product_id'=>$id,
		    				'puser_group_id'=>243211
		    				);
		    			CepProductUsers::create($list);
					}
				
			
			}
		}

		foreach ($difference as $key => $value) {
			CepProductUsers::where('puser_user_id','=',$value)
								->where('puser_product_id','=',$id)
								->delete();
		}

		if(!empty($errors)){
    		return redirect()->back()->withErrors($errors);
    	}else{
    		return redirect()->back()->with('success', array($this->dictionary->msg_bo_list_success));
    	}


	}

	public function viewReference($id){
        $product_id = $id;
		$reference_listing = array();
		$folder_listing = array();
        $dir = public_path()."/uploads/products/".$id."/ftp/";
		if ($handle = opendir($dir)) {
 		   while (false !== ($entry = readdir($handle))) {
        		if ($entry != "." && $entry != "..") {
            		$folder_listing[] = $entry;
        		}
    		}
    		closedir($handle);
		}

		$data = Request::all();
		$folder_show = "";
		if(empty($data))
			$folder_show = $folder_listing[0];
		else
			$folder_show = $data['f'];

		$dir = public_path()."/uploads/products/".$id."/ftp/".$folder_show."/";
		if ($handle = opendir($dir)) {
 		   while (false !== ($entry = readdir($handle))) {
        		if ($entry != "." && $entry != "..") {
            		$part = explode("_",$entry);
            		if(!in_array($part[0],$reference_listing))	
            			$reference_listing[] = $part[0];
        		}
    		}
    		closedir($handle);
		}

		//echo "<pre>"; print_r($reference_listing); exit;
		return view("product.reference", compact('folder_listing','reference_listing','product_id','folder_show'));
	}


	public function viewReferenceImage($id){
		$product_id = $id;
		$data = Request::all();
		$folder_show = "";
		if(empty($data))
			return redirect('accessDenied');
		else{
			$folder_show = $data['f'];
			$images_show = $data['r'];
		}

		$reference_listing = array();
		$dir = public_path()."/uploads/products/".$id."/ftp/".$folder_show."/";
		if ($handle = opendir($dir)) {
 		   while (false !== ($entry = readdir($handle))) {
        		if ($entry != "." && $entry != "..") {
					$part = explode("_",$entry);
            		if(strcmp($part[0],$data['r']) == 0){
            			$reference_listing1['ref_path'] = "/uploads/products/".$id."/ftp/".$folder_show."/".$entry;
            			$reference_listing1['ref_id'] = $entry;
            			$reference_listing[] = $reference_listing1;
            		}	
        		}
    		}
    		closedir($handle);
		}

			return view("product.reference_image",compact('product_id','reference_listing','images_show','product_id'));
	}

	/**
	 * Function ftp
	 *
	 * @param
	 * @return
	 */		
	public function ftp($id)
	{	
		$ftp='';
		return view("product.ftp",compact('ftp'));
	}

	/**
	 * Function pdn
	 *
	 * @param
	 * @return
	 */		
	public function pdn($id)
	{
		$pdn='';
		$prodConfigs=array();	
		$alphaRange=array_combine(range('1','26'),range('A','Z'));	
		$prodConfigs['pdn']=CepProductConfigurations::where('pconf_type','=','pdn')
										 ->where('pconf_product_id','=',$id)
										 ->first();

        $prodConfigs['pdn_uploads_verify'] = CepUploads::leftjoin('cep_user_plus','upload_by','=','up_user_id')
        					->where('upload_type','=','pdn')
        					->where('upload_product_id','=',$id)
        					->where('upload_verification_status','=',0)
        					->select(DB::raw('date_format(upload_date,"%d, %M %y %h:%i %p") as dt,up_first_name,up_last_name,upload_by, upload_original_name,upload_name,upload_url,upload_id,upload_verification_status'))
        					->get();


		$prodConfigs['pdn_uploads_verifed'] = CepUploads::leftjoin('cep_user_plus','upload_by','=','up_user_id')
        					->where('upload_type','=','pdn')
        					->where('upload_product_id','=',$id)
        					->where(function ($query) {
        						$query->where('upload_verification_status','=',2)
        						->orwhere('upload_verification_status','=',1);
        					})
        					->select(DB::raw('date_format(upload_date,"%d, %M %y %h:%i %p") as dt,up_first_name,up_last_name,upload_by, upload_original_name,upload_name,upload_url,upload_id,upload_verification_status,	upload_verification_msg,upload_reference_column'))
        					->get();

        return view("product.pdn",compact('pdn','prodConfigs','alphaRange'));
	}
	/**
	 * Function ref
	 *
	 * @param
	 * @return
	 */	
	public function ref($id)
	{
		$ref='';
		$alphaRange=array_combine(range('1','26'),range('A','Z'));	
		$prodConfigs['ref']=CepProductConfigurations::where('pconf_type','=','ref')
										 ->where('pconf_product_id','=',$id)
										 ->first();

        $prodConfigs['ref_uploads_verify'] = CepUploads::leftjoin('cep_user_plus','upload_by','=','up_user_id')
        					->where('upload_type','=','ref')
        					->where('upload_product_id','=',$id)
        					->where('upload_verification_status','=',0)
        					->select(DB::raw('date_format(upload_date,"%d, %M %y %h:%i %p") as dt,up_first_name,up_last_name,upload_by, upload_original_name,upload_name,upload_url,upload_id,upload_verification_status'))
        					->get();

		$prodConfigs['ref_uploads_verifed'] = CepUploads::leftjoin('cep_user_plus','upload_by','=','up_user_id')
        					->where('upload_type','=','ref')
        					->where('upload_product_id','=',$id)
        					->where(function ($query) {
        						$query->where('upload_verification_status','=',2)
        						->orwhere('upload_verification_status','=',1);
        					})
        					->select(DB::raw('date_format(upload_date,"%d, %M %y %h:%i %p") as dt,up_first_name,up_last_name,upload_by, upload_original_name,upload_name,upload_url,upload_id,upload_verification_status,	upload_verification_msg,upload_reference_column'))
        					->get();
		
		//echo "<pre>"; print_r ($prodConfigs); exit;
		return view("product.ref",compact('prodConfigs','alphaRange'));
	}

	public function refUpload($id)
	{

		$data = Request::all(); 
		$validate = Validator::make($data,[
                 		'file_ref' => 'required',
 			    		'pdn_ref' => 'required'
                 	]);

	
        if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());              
                }


		$itemData = CepItems::leftjoin('cep_product_users','item_product_id','=','puser_product_id')
							->leftjoin('users','puser_user_id','=','id')
							->leftjoin('cep_groups','cep_groups.group_id','=','users.group_id')
							->where('item_id',$data['pconf_item_id'])
							->where('group_code','CL')
							->select('id','item_product_id','item_id')
							->first();


        $file=Input::file('file_ref_1');
        //print_r($file);
		$upload=array();
			if($file){
		        $name=uniqid();
				$options =array ( 
			 				'name'=>$name,
			 				'type'=>'ref',
							'description'=> 'refupload',
							'url'=> 'products/'.$itemData->item_product_id.'/ref/',
							'client'=> $itemData->id,
							'product'=> $itemData->item_product_id,
							'item'=> $itemData->item_id, 
							'reference_column'=> $data['pdn_ref'],
							 );

				

				$FileManager=new FileManager();
				$upload=$FileManager->upload($file,$options);
				/* Activity Email Alerts */		
				if(!is_null($upload)){
					$productHelper=new ProductHelper;
					$prod=$productHelper->checkProductExists($itemData->item_product_id);
					$prodUsers=$productHelper->getClientProductUsers($itemData->item_product_id,array('BO'));
					//echo "<pre>"; print_r($prodUsers);exit;
					$variable = '{ "EM_PRODUCT ": "'.$prod->name.'"}';
					foreach ($prodUsers as $key => $value) {
						$option = array(
	        				'em_type'=>1, 
	        				'em_from'=>$this->configs->email_no_reply_user_id,
	        				'em_to'=>$key,
	        				'em_variables'=>$variable,
	        				'em_subject' => $this->configs->reference_file_upload_template_subject,
	        				'eticket_template_id' => $this->configs->reference_file_upload_template_id,
	        				'em_ticket_id' => 0,
    					);
    					$this->emailActivity->sendMessage($option);
					}
    				/* Activity Custom */

			        $variable_act = '{ "AC_PRODUCT": "'.$prod->name .'"}';

			        $act_options = array(
			                            'act_template_id' => $this->configs->reference_file_upload_activity_template_id,
			                            'act_by' => Auth::id(),
			                            'act_product_id' => $itemData->item_product_id,
			                            'act_variables' => $variable_act
			                           );
			        $this->customactivity->postActivity($act_options);

	                /* Close Activity Custom */ 

				}
				/* Close Activity Email Alerts */
				 
			}

			return redirect()->back();
	}

	public function refUploadVerify($id)
	{
		$data = Request::only('upload_verification_msg');
		$updateData = array('upload_verification_msg' => $data['upload_verification_msg'], 'upload_verification_by' => Auth::id(), 'upload_verification_status' => 2);
		CepUploads::where('upload_id',$id)->update($updateData);
		$upload=CepUploads::where('upload_id',$id)->first();
		//echo "<pre>"; print_r($upload);exit;
		/* Activity Email Alerts */		
		if(!is_null($upload)){
			$productHelper=new ProductHelper;
			$prod=$productHelper->checkProductExists($upload->upload_product_id);
			$prodUsers=$productHelper->getClientProductUsers($upload->upload_product_id,array('CL','CM'));
			//echo "<pre>"; print_r($prodUsers);exit;
			$variable = '{ "EM_PRODUCT ": "'.$prod->name.'"}';
			foreach ($prodUsers as $key => $value) {
				$option = array(
    				'em_type'=>1, 
    				'em_from'=>$this->configs->email_no_reply_user_id,
    				'em_to'=>$key,
    				'em_variables'=>$variable,
    				'em_subject' => $this->configs->reference_file_rejected_template_subject,
    				'eticket_template_id' => $this->configs->reference_file_rejected_template_id,
    				'em_ticket_id' => 0,
				);
				$this->emailActivity->sendMessage($option);
			}
			/* Activity Custom */

	        $variable_act = '{ "AC_PRODUCT": "'.$prod->name .'"}';

	        $act_options = array(
	                            'act_template_id' => $this->configs->reference_file_reject_activity_template_id,
	                            'act_by' => Auth::id(),
	                            'act_product_id' => $upload->upload_product_id,
	                            'act_variables' => $variable_act
	                           );
	        $this->customactivity->postActivity($act_options);

            /* Close Activity Custom */ 

		}
		/* Close Activity Email Alerts */

		 return redirect()->back();
	}

	public function pdnUpload($id)
	{
		$data = Request::all();

		$validate = Validator::make($data,[
               		'file_pdn_1' => 'required',
 		    		'pdn_pdn' => 'required'
               	]);

		if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());              
        }


		//print_r ($data); exit;		
		$itemData = CepItems::leftjoin('cep_product_users','item_product_id','=','puser_product_id')
							->leftjoin('users','puser_user_id','=','id')
							->leftjoin('cep_groups','cep_groups.group_id','=','users.group_id')
							->where('item_id',$data['pconf_item_id'])
							->where('group_code','CL')
							->select('id','item_product_id','item_id')
							->first();


		//print_r ($itemData);
        $file=Input::file('file_pdn_1');

		$upload=array();
			if($file){
		        $name=uniqid();
				$options =array ( 
			 				'name'=>$name,
			 				'type'=>'pdn',
							'description'=> 'pdnupload',
							'url'=> 'products/'.$itemData->item_product_id.'/pdn/',
							'client'=> $itemData->id,
							'product'=> $itemData->item_product_id,
							'item'=> $itemData->item_id, 
							'reference_column'=> $data['pdn_pdn'],
							 );

					$FileManager=new FileManager();
					$upload=$FileManager->upload($file,$options);
			}

			return redirect()->back();
	}

	public function pdnUploadVerify($id)
	{
		 $data = Request::only('upload_verification_msg');
		 $updateData = array('upload_verification_msg' => $data['upload_verification_msg'], 'upload_verification_by' => Auth::id(), 'upload_verification_status' => 2);
		 CepUploads::where('upload_id',$id)->update($updateData);

		 return redirect()->back();
	}


		/**
	 * Function ref
	 *
	 * @param
	 * @return
	 */	
	public function delivery($id)
	{
		$delivery='';
		$alphaRange=array_combine(range('1','26'),range('A','Z'));	
		$prodConfigs['delivery']=CepProductConfigurations::where('pconf_type','=','delivery')
										 ->where('pconf_product_id','=',$id)
										 ->first();

        $prodConfigs['delivery_uploads_verify'] = CepUploads::leftjoin('cep_user_plus','upload_by','=','up_user_id')
        					->where('upload_type','=','delivery')
        					->where('upload_product_id','=',$id)
        					->where('upload_verification_status','=',0)
        					->select(DB::raw('date_format(upload_date,"%d, %M %y %h:%i %p") as dt,up_first_name,up_last_name,upload_by, upload_original_name,upload_name,upload_url,upload_id,upload_verification_status'))
        					->get();


		$prodConfigs['delivery_uploads_verifed'] = CepUploads::leftjoin('cep_user_plus','upload_by','=','up_user_id')
        					->where('upload_type','=','delivery')
        					->where('upload_product_id','=',$id)
        					->where(function ($query) {
        						$query->where('upload_verification_status','=',2)
        						->orwhere('upload_verification_status','=',1);
        					})
        					->select(DB::raw('date_format(upload_date,"%d, %M %y %h:%i %p") as dt,up_first_name,up_last_name,upload_by, upload_original_name,upload_name,upload_url,upload_id,upload_verification_status,	upload_verification_msg,upload_reference_column'))
        					->get();
		
		//echo "<pre>"; print_r ($prodConfigs); exit;
		return view("product.delivery",compact('prodConfigs','alphaRange'));
	}


	public function deliveryUpload($id)
	{
		$data = Request::all();

		$validate = Validator::make($data,[
               		'file_delivery_1' => 'required',
 		    		'pdn_ref' => 'required'
               	]);

		if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());              
        }

		//print_r ($data); exit;		
		$itemData = CepItems::leftjoin('cep_product_users','item_product_id','=','puser_product_id')
							->leftjoin('users','puser_user_id','=','id')
							->leftjoin('cep_groups','cep_groups.group_id','=','users.group_id')
							->where('item_id',$data['pconf_item_id'])
							->where('group_code','CL')
							->select('id','item_product_id','item_id')
							->first();


		//print_r ($itemData);
        $file=Input::file('file_delivery_1');
        print_r($file);
		$upload=array();
			if($file){
		        $name=uniqid();
				$options =array ( 
			 				'name'=>$name,
			 				'type'=>'delivery',
							'description'=> 'deliveryupload',
							'url'=> 'products/'.$itemData->item_product_id.'/delivery/',
							'client'=> $itemData->id,
							'product'=> $itemData->item_product_id,
							'item'=> $itemData->item_id, 
							'reference_column'=> $data['pdn_ref'],
							 );

					$FileManager=new FileManager();
					$upload=$FileManager->upload($file,$options);
					/* Activity Email Alerts */		
					if(!is_null($upload)){
						$productHelper=new ProductHelper;
						$prod=$productHelper->checkProductExists($itemData->item_product_id);
						$prodUsers=$productHelper->getClientProductUsers($itemData->item_product_id,array('CL','CM'));
						//echo "<pre>"; print_r($prodUsers);exit;
						$variable = '{ "EM_PRODUCT ": "'.$prod->name.'"}';
						foreach ($prodUsers as $key => $value) {
							$option = array(
		        				'em_type'=>1, 
		        				'em_from'=>$this->configs->email_no_reply_user_id,
		        				'em_to'=>$key,
		        				'em_variables'=>$variable,
		        				'em_subject' => $this->configs->delivery_file_upload_template_subject,
		        				'eticket_template_id' => $this->configs->delivery_file_upload_template_id,
		        				'em_ticket_id' => 0,
	    					);
	    					$this->emailActivity->sendMessage($option);
						}
	    				/* Activity Custom */

				        $variable_act = '{ "AC_PRODUCT": "'.$prod->name .'"}';

				        $act_options = array(
				                            'act_template_id' => $this->configs->delivery_file_upload_activity_template_id,
				                            'act_by' => Auth::id(),
				                            'act_product_id' => $itemData->item_product_id,
				                            'act_variables' => $variable_act
				                           );
				        $this->customactivity->postActivity($act_options);

		                /* Close Activity Custom */ 

					}
					/* Close Activity Email Alerts */

			}

			return redirect()->back();
	}

	public function deliveryUploadVerify($id)
	{
		 $data = Request::only('upload_verification_msg');
		 $updateData = array('upload_verification_msg' => $data['upload_verification_msg'], 'upload_verification_by' => Auth::id(), 'upload_verification_status' => 2);
		 CepUploads::where('upload_id',$id)->update($updateData);

		$upload=CepUploads::where('upload_id',$id)->first();
		//echo "<pre>"; print_r($upload);exit;
		/* Activity Email Alerts */		
		if(!is_null($upload)){
			$productHelper=new ProductHelper;
			$prod=$productHelper->checkProductExists($upload->upload_product_id);
			$prodUsers=$productHelper->getClientProductUsers($upload->upload_product_id,array('BO'));
			//echo "<pre>"; print_r($prodUsers);exit;
			$variable = '{ "EM_PRODUCT ": "'.$prod->name.'"}';
			foreach ($prodUsers as $key => $value) {
				$option = array(
    				'em_type'=>1, 
    				'em_from'=>$this->configs->email_no_reply_user_id,
    				'em_to'=>$key,
    				'em_variables'=>$variable,
    				'em_subject' => $this->configs->delivery_file_approve_template_subject,
    				'eticket_template_id' => $this->configs->delivery_file_approve_template_id,
    				'em_ticket_id' => 0,
				);
				$this->emailActivity->sendMessage($option);
			}
			/* Activity Custom */

	        $variable_act = '{ "AC_PRODUCT": "'.$prod->name .'"}';

	        $act_options = array(
	                            'act_template_id' => $this->configs->delivery_file_reject_activity_template_id,
	                            'act_by' => Auth::id(),
	                            'act_product_id' => $upload->upload_product_id,
	                            'act_variables' => $variable_act
	                           );
	        $this->customactivity->postActivity($act_options);

            /* Close Activity Custom */ 

		}
		/* Close Activity Email Alerts */

		 return redirect()->back();
	}

	public function approveUpload($id)
	{
		$updateData = array('upload_verification_by' => Auth::id(), 'upload_verification_status' => 1);
		CepUploads::where('upload_id',$id)->update($updateData);
		$uploadData=CepUploads::where('upload_id',$id)->first();
		//echo "<pre>"; print_r($uploadData);exit;
		if($uploadData['upload_type']=='ref'){

			$productId=$uploadData['upload_product_id'];
			$productHelper=new ProductHelper();
			
			/* Check if type of wrting is of File where only ReF file available and Generated reference on FLy */		
			if($productId!='' &&  $productHelper->checkRefAvailable($productId) && !$productHelper->checkPdnAvailable($productId))
			{	
				
				/* Get Gen Info from Product  Configurations  */		
				$GenInfo=$productHelper->checkGenAvailable($productId,true);
				if($GenInfo['pconf_path']!=''){
					$routes = \Route::getRoutes();
					$request = Request::create($GenInfo['pconf_path']."/".$id);
					try {
					    $routes->match($request);
					    // route exists
					    $upload=CepUploads::where('upload_id',$id)->first();
						//echo "<pre>"; print_r($upload);exit;
						/* Activity Email Alerts */		
						if(!is_null($upload)){
							$productHelper=new ProductHelper;
							$prod=$productHelper->checkProductExists($upload->upload_product_id);
							$prodUsers=$productHelper->getClientProductUsers($upload->upload_product_id,array('CL','CM'));
							//echo "<pre>"; print_r($prodUsers);exit;
							$variable = '{ "EM_PRODUCT ": "'.$prod->name.'"}';
							foreach ($prodUsers as $key => $value) {
								$option = array(
				    				'em_type'=>1, 
				    				'em_from'=>$this->configs->email_no_reply_user_id,
				    				'em_to'=>$key,
				    				'em_variables'=>$variable,
				    				'em_subject' => $this->configs->reference_file_approve_template_subject,
				    				'eticket_template_id' => $this->configs->reference_file_approve_template_id,
				    				'em_ticket_id' => 0,
								);
								$this->emailActivity->sendMessage($option);
							}
							/* Activity Custom */

					        $variable_act = '{ "AC_PRODUCT": "'.$prod->name .'"}';

					        $act_options = array(
					                            'act_template_id' => $this->configs->reference_file_approve_activity_template_id,
					                            'act_by' => Auth::id(),
					                            'act_product_id' => $upload->upload_product_id,
					                            'act_variables' => $variable_act
					                           );
					        $this->customactivity->postActivity($act_options);

				            /* Close Activity Custom */ 

						}
						/* Close Activity Email Alerts */


					    return redirect($GenInfo['pconf_path']."/".$id);
					}
					catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
					    // Route doesn't exist
					  	// Revert Update Verification
					    $updateData = array('upload_verification_by' =>'' , 'upload_verification_status' => 0);
						CepUploads::where('upload_id',$id)->update($updateData);
						return redirect()->back()->with('customError', array($this->dictionary->msg_file_validation_error_type_file));
					}
					
				}
				
			}
		}else if($uploadData['upload_type']=='delivery'){
			$upload=CepUploads::where('upload_id',$id)->first();
			//echo "<pre>"; print_r($upload);exit;
			/* Activity Email Alerts */		
			if(!is_null($upload)){
				$productHelper=new ProductHelper;
				$prod=$productHelper->checkProductExists($upload->upload_product_id);
				$prodUsers=$productHelper->getClientProductUsers($upload->upload_product_id,array('BO'));
				//echo "<pre>"; print_r($prodUsers);exit;
				$variable = '{ "EM_PRODUCT ": "'.$prod->name.'"}';
				foreach ($prodUsers as $key => $value) {
					$option = array(
	    				'em_type'=>1, 
	    				'em_from'=>$this->configs->email_no_reply_user_id,
	    				'em_to'=>$key,
	    				'em_variables'=>$variable,
	    				'em_subject' => $this->configs->delivery_file_approve_template_subject,
	    				'eticket_template_id' => $this->configs->delivery_file_approve_template_id,
	    				'em_ticket_id' => 0,
					);
					$this->emailActivity->sendMessage($option);
				}
				/* Activity Custom */

		        $variable_act = '{ "AC_PRODUCT": "'.$prod->name .'"}';

		        $act_options = array(
		                            'act_template_id' => $this->configs->delivery_file_approve_activity_template_id,
		                            'act_by' => Auth::id(),
		                            'act_product_id' => $upload->upload_product_id,
		                            'act_variables' => $variable_act
		                           );
		        $this->customactivity->postActivity($act_options);

	            /* Close Activity Custom */ 
			}
			/* Close Activity Email Alerts */
		}
		
		return redirect()->back();
	}

	
	public function writer($id){
		$writerFileList = CepDownloads::where('download_product_id',$id)
						->where('download_type','=','writer')
						->select(DB::raw("date_format(download_date,'%d %M %Y') as dt,download_name,download_description,download_url"))
						->get();
		return view("product.writer",compact('writerFileList'));
	}

}
