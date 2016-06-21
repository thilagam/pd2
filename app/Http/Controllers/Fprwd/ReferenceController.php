<?php namespace App\Http\Controllers\Fprwd;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use App\CepProductConfigurations;
use App\CepItemConfigurations;
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
use App\Libraries\ExcelLib;

class ReferenceController extends Controller {


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
      $this->excellibobj = new ExcelLib;
      $this->FileManager=new FileManager();

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


  public function refAfterUpload($id)
  {
      CepUploads::where('upload_id',$id)->update(array('upload_status'=>1));
      return redirect()->back();
  }

	/**
	 * Function ref
	 *
	 * @param
	 * @return
	 */
	public function refUpload($id)
	{
    if(Request::isMethod('get'))
        return redirect("/product/ref/$id");

		$data = Request::all();
		$validate = Validator::make($data,[
                 		'file_ref' => 'required',
 			    		 'pdn_ref' => 'required'
                 	]);


        if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());
                }

    $upload_status = CepItemConfigurations::where('iconf_product_id',$id)
                     ->where('iconf_item_id','link_ref')
                     ->where('iconf_name','checkUploadFile')
                     ->select('iconf_value')
                     ->first();

    $filepath = "";
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
              'status'=> ($upload_status['iconf_value'] == 0) ? 1 : 0
							 );

				$upload=$this->FileManager->upload($file,$options);

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
      $devConfig = CepItemConfigurations::where('iconf_product_id',$id)
                    ->where('iconf_item_id','link_ref')
                    ->get();

      $validate_array = $this->excellibobj->fileValidate($upload['upload_url']);

      $devConfigArray = array();
      foreach($devConfig as $key=>$dca)
          $devConfigArray[$dca->iconf_name] = json_decode($dca->iconf_value,true);
      //echo "<pre>"; print_r ($devConfigArray); exit;

/* comparedArray create */

      $comparedArray = array();

      //foreach($validate_array as $va)
      //{
           $comparedArray['fileSize'] = array('currentfile'=>$validate_array['fileSize'],  'devconfig'=>$devConfigArray['fileSize'], 'status'=>($validate_array['fileSize'] == $devConfigArray['fileSize']) ? "none" : "alert-danger");
           $comparedArray['sheetCount'] = array('currentfile'=>$validate_array['sheetCount'],  'devconfig'=>$devConfigArray['sheetCount'], 'status'=>($validate_array['sheetCount'] == $devConfigArray['sheetCount']) ? "none" : "alert-danger");
           $comparedArray['sheetDimensionStatus']='none';
           $comparedArray['sheetHeader']=array();
           foreach($validate_array['sheetDimension'] as $key=>$va)
           {
                if (array_key_exists($key, $devConfigArray['sheetDimension']))
                {
                  $comparedArray['sheetHeader']['sheetMissingColumn'][$key]='Missing Column:- ';
                  $comparedArray['sheetHeader']['sheetExtraColumn'][$key]='Extra Column:- ';

                  foreach($devConfigArray['sheetData'][$key][1] as $columnData){
                        if(!in_array($columnData,$validate_array['sheetData'][$key][1]))
                          $comparedArray['sheetHeader']['sheetMissingColumn'][$key].=$columnData.",";
                  }
                  foreach($validate_array['sheetData'][$key][1] as $columnData){
                        if(!in_array($columnData,$devConfigArray['sheetData'][$key][1]))
                          $comparedArray['sheetHeader']['sheetExtraColumn'][$key].=$columnData.",";
                  }

                  $column_range_1 = "Sheet Title:- ".$validate_array['sheetTitle'][$key]."<br /> Column Range:- ".preg_replace('/[^A-Z,:]/', '', $devConfigArray['sheetDimension'][$key])."<br /> Row Count:- ". preg_replace('/[^0-9,:]/', '', $devConfigArray['sheetDimension'][$key]);
                  $column_range_2 = "Sheet Title:- ".$validate_array['sheetTitle'][$key]."<br /> Column Range:- ".preg_replace('/[^A-Z,:]/', '', $validate_array['sheetDimension'][$key])."<br /> Row Count:- ". preg_replace('/[^0-9,:]/', '', $validate_array['sheetDimension'][$key]);
                  $comparedArray['sheetDimension']['devconfig'][$key] = $column_range_1;
                  $comparedArray['sheetDimension']['currentfile'][$key] = $column_range_2;
                  $comparedArray['sheetDimensionStatus'] =  ($comparedArray['sheetDimension']['currentfile'][$key] == $comparedArray['sheetDimension']['devconfig'][$key] && $comparedArray['sheetDimensionStatus']!='alert-danger') ? "none" : "alert-danger";

                    //echo "<pre>"; print_r ($devConfigArray['sheetData'][$key][1]);
                }

           }



      //}

      //echo "<pre>"; print_r ($comparedArray); exit;
      $logs_details = json_encode($comparedArray);
  /* close comparedArray */
      $uploadLogsOptions = array(
                                  'uplog_upload_id'=>$upload->upload_id,
                                  'uplog_logs'=>$logs_details,
                                  'uplog_check_upload'=>$upload_status['iconf_value'],
                                  'uplog_check_status'=>(strpos($logs_details, 'alert-danger') == true ? 1 : 0)
                                );

      $uploadLogs = $this->FileManager->uploadLogs($uploadLogsOptions);

      if($upload_status['iconf_value'] == 0)
          return redirect()->back();

      return view("product.ref_verify",compact('validate_array','devConfigArray','comparedArray','upload'));
	}

	/**
	 * Function ref
	 *
	 * @param
	 * @return
	 */
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



}
