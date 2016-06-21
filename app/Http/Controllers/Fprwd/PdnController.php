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

class PdnController extends Controller {


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
	 * Function pdnUpload
	 *
	 * @param
	 * @return
	 */

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


	/**
	 * Function pdnUploadVerify
	 *
	 * @param
	 * @return
	 */
	public function pdnUploadVerify($id)
	{
		 $data = Request::only('upload_verification_msg');
		 $updateData = array('upload_verification_msg' => $data['upload_verification_msg'], 'upload_verification_by' => Auth::id(), 'upload_verification_status' => 2);
		 CepUploads::where('upload_id',$id)->update($updateData);

		 return redirect()->back();
	}

}
