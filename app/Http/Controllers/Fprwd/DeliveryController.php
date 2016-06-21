<?php namespace App\Http\Controllers\Fprwd;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use App\CepProductConfigurations;
use App\CepUploads;
use App\CepItems;
use DB;
use Auth;
use Validator;
use Input;

/* Services */		
use App\Services\UploadsManager;

/* Libraries */		
use App\Libraries\FileManager; 
use App\Libraries\CheckAccessLib;
use App\Libraries\ProductHelper;
use App\Libraries\EMailer;
use App\Libraries\ActivityMainLib;

class DeliveryController extends Controller {

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
	 * Function delivery
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

	
	/**
	 * Function deliveryUpload
	 *
	 * @param
	 * @return
	 */	

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

	/**
	 * Function deliveryUploadVerify
	 *
	 * @param
	 * @return
	 */	

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
	

}
