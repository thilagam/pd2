<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use Input;
use App\User;
use DB;
use App\CepAppointments;
use Validator;
use Cookie;
use Auth;
use Datetime;

use App\CepGroups;
use App\CepProducts;
use App\CepAttachmentFiles;

use App\Libraries\CheckAccessLib;
use App\Libraries\EMailer;
use App\CepProductUsers;
use App\Libraries\ActivityMainLib;
use App\Libraries\FileManager;

class AppointmentController extends Controller {
	

	public $configs;
	public $permit;
	private $checkaccess;
    protected $customactivity;
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
    		 $this->checkaccess = new CheckAccessLib;
    		 $this->emailActivity = new EMailer;
             $this->customactivity = new ActivityMainLib;
             $this->attachment = new FileManager;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(!$this->permit->module_client_appointments)
            return redirect('accessDenied');		

        $appointments="";
        $group = CepGroups::where('group_id',Auth::user()->group_id)->first();

		$appointments_query = CepAppointments::with('clientRelationship','productRelationship','epInchargeRelationship','clientInchargeRelationship');

		if($group->group_code == "SA" || $group->group_code == "DEV"){	
		       $appointments = $appointments_query->get();
		}else{
		       $appointments = $appointments_query->where('apo_client_id',Auth::id())
									   ->orWhere('apo_ep_incharge_id',Auth::id())
									   ->orWhere('apo_client_incharge_id',Auth::id())
									   ->orWhere('apo_created_by',Auth::id())
									   ->get();			
		}

		return view('appointments.index',compact('appointments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->module_client_appointments_create)
            return redirect('accessDenied');

		$clients = DB::table('users')
		        ->leftjoin('cep_groups','cep_groups.group_id','=','users.group_id')
	                ->where('cep_groups.group_code','=',"CL")
			->where('users.status','=',1)
			->select('users.id', 'users.name','users.email','users.group_id')
			->get();
		$client_array = array();
		$client_array[""] = "Select";
		foreach($clients as $client)
			$client_array[$client->id] = $client->name." ( ".$client->email." )"; 	 
		$product_array[""] = "Select";
		$item_array[""] = "Select";
		$epincharge_array[""] = "Select";

		return view('appointments.create',compact('client_array','product_array','item_array','epincharge_array'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$appointments = Request::all();

       	$validate = Validator::make($appointments,[
                            'apo_client_id' => 'required',
                            'apo_product_id' => 'required',
			   // 'apo_item_id' => 'required',	
			    'apo_ep_incharge_id' => 'required',
			    'apo_client_incharge_id' => 'required',
			    'apo_date' => 'required',	
                'apo_time' => 'required',
			    'apo_subject' => 'required',
			    'apo_description' => 'required',	
                ]);
		if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }	

        $datetime = $appointments['apo_date']." ".$appointments['apo_time'];
        $now = DateTime::createFromFormat('D, d F Y h:i A',trim($datetime));
        $appointments['apo_datetime'] = $now->format('Y-m-d H:i:s');

        if(Input::hasFile('files')){  
            $files=Input::file('files');      
            $appointments['apo_attachement_id'] = $this->attachment->createAttachment(array('att_type'=>'appointments'));       
            foreach($files as $key=>$fl){
                    //echo "<pre>"; print_r ($appointments['files'][$key]); //exit;
                    $this->attachment->uploadAttachmentFiles($fl,$appointments['apo_attachement_id']);
            }
        }   
        //exit; 

		$newAppointment = CepAppointments::create($appointments);

		$app = CepProducts::where("prod_id",$appointments['apo_product_id'])->select('prod_name','prod_id')->first();

        /* Activity Email Alerts */

        $variable = '{ "EM_PRODUCT":"'.$app->prod_name.'" }';

        $option = array(
                        'em_type'=>1, 
                        'em_from'=> $this->configs->email_no_reply_user_id,
                        'em_to'=>$appointments['apo_client_id'],
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->appointment_creation_email_template_subject,
                        'eticket_template_id' => $this->configs->appointment_creation_email_template_id,
                        'em_ticket_id' => 0,
                        );
        $this->emailActivity->sendMessage($option);


        $variable = '{ "EM_PRODUCT":"'.$app->prod_name.'" }';

        $option = array(
                        'em_type'=>1, 
                        'em_from'=> $this->configs->email_no_reply_user_id,
                        'em_to'=>$appointments['apo_ep_incharge_id'],
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->appointment_creation_email_template_subject,
                        'eticket_template_id' => $this->configs->appointment_creation_email_template_id,
                        'em_ticket_id' => 0,
                        );
        $this->emailActivity->sendMessage($option);


        $variable = '{ "EM_PRODUCT":"'.$app->prod_name.'" }';

        $option = array(
                        'em_type'=>1, 
                        'em_from'=> $this->configs->email_no_reply_user_id,
                        'em_to'=>$appointments['apo_client_incharge_id'],
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->appointment_creation_email_template_subject,
                        'eticket_template_id' => $this->configs->appointment_creation_email_template_id,
                        'em_ticket_id' => 0,
                        );
        $this->emailActivity->sendMessage($option);

		/* Close Activity Email Alerts */


         /* Activity Custom */

        $variable_act = '{ "AC_NAME": "'.Auth::user()->name.'","AC_CL_PRODUCT": "'.$app->prod_name.'" }';

        $act_options = array(
                            'act_template_id' => $this->configs->appointment_creation_activity_template_id,
                            'act_by' => Auth::id(),
                            'act_product_id' => $app->prod_id,
                            'act_variables' => $variable_act
                           );
        $this->customactivity->postActivity($act_options);

        /* Close Activity Custom */  

		return redirect('appointments');
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
		if(!$this->permit->module_client_appointments_read)
            return redirect('accessDenied');

        if(!$this->checkaccess->appointmentAccessCheck($id))
         		return redirect('accessDenied');

		$appointment = CepAppointments::find($id);
		$now = DateTime::createFromFormat('Y-m-d H:i:s',trim($appointment['apo_datetime']));
		$appointment['apo_date'] = $now->format('D, d F Y'); 
 		$appointment['apo_time'] = $now->format('h:i A');

        $attachments = CepAttachmentFiles::where('attfiles_attachment_id',$appointment['apo_attachement_id'])->get();

		return view('appointments.show',compact('appointment','attachments'));
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
		if(!$this->permit->module_client_appointments_edit)
            return redirect('accessDenied');

		if(!$this->checkaccess->appointmentAccessCheck($id))
        	return redirect('accessDenied');       

                $appointment = CepAppointments::find($id);
                $now = DateTime::createFromFormat('Y-m-d H:i:s',trim($appointment['apo_datetime']));
                $appointment['apo_date'] = $now->format('D, d F Y');
                $appointment['apo_time'] = $now->format('h:i A');

        $attachments = CepAttachmentFiles::where('attfiles_attachment_id',$appointment['apo_attachement_id'])->get();
                return view('appointments.edit',compact('appointment','attachments'));
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
		$dummy= Request::only('apo_date','apo_time');
                $appointments = Request::only('apo_subject','apo_description');
                $datetime = $dummy['apo_date']." ".$dummy['apo_time'];
                $now = DateTime::createFromFormat('D, d F Y h:i A',trim($datetime));
                $appointments['apo_datetime'] = $now->format('Y-m-d H:i:s');
                $validate = Validator::make($appointments,[
               		    'apo_datetime' => 'required',
                            'apo_subject' => 'required',
                            'apo_description' => 'required',
                ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }

		$affectedRows = CepAppointments::where('apo_id',$id)->update($appointments);
		$appointments = CepAppointments::where('apo_id',$id)->first();

		$app = CepProducts::where("prod_id", $appointments['apo_product_id'])->select('prod_name','prod_id')->first();

        /* Activity Email Alerts */

        $variable = '{ "EM_PRODUCT":"'.$app->prod_name.'" }';

        $option = array(
                        'em_type'=>1, 
                        'em_from'=> $this->configs->email_no_reply_user_id,
                        'em_to'=>$appointments['apo_client_id'],
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->appointment_update_email_template_subject,
                        'eticket_template_id' => $this->configs->appointment_update_email_template_id,
                        'em_ticket_id' => 0,
                        );
        $this->emailActivity->sendMessage($option);


        $variable = '{ "EM_PRODUCT":"'.$app->prod_name.'" }';

        $option = array(
                        'em_type'=>1, 
                        'em_from'=> $this->configs->email_no_reply_user_id,
                        'em_to'=>$appointments['apo_ep_incharge_id'],
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->appointment_update_email_template_subject,
                        'eticket_template_id' => $this->configs->appointment_update_email_template_id,
                        'em_ticket_id' => 0,
                        );
        $this->emailActivity->sendMessage($option);


        $variable = '{ "EM_PRODUCT":"'.$app->prod_name.'" }';

        $option = array(
                        'em_type'=>1, 
                        'em_from'=> $this->configs->email_no_reply_user_id,
                        'em_to'=>$appointments['apo_client_incharge_id'],
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->appointment_update_email_template_subject,
                        'eticket_template_id' => $this->configs->appointment_update_email_template_id,
                        'em_ticket_id' => 0,
                        );
        $this->emailActivity->sendMessage($option);

		/* Close Activity Email Alerts */

                 /* Activity Custom */

        $variable_act = '{ "AC_NAME": "'.Auth::user()->name.'","AC_CL_PRODUCT": "'.$app->prod_name.'" }';

        $act_options = array(
                            'act_template_id' => $this->configs->appointment_update_activity_template_id,
                            'act_by' => Auth::id(),
                            'act_product_id' => $app->prod_id,
                            'act_variables' => $variable_act
                           );
        $this->customactivity->postActivity($act_options);

        /* Close Activity Custom */  


	        return redirect('appointments');
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
		CepAppointments::destroy($id);
	        return redirect('appointments');
	}

        /**
         * Ajax function to bring product list as per client.
         *
         * @param int $id
         * @return Response select box
         */

	public function productAjaxCall(){
		$data = Input::all();
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
                    ->where('id','=',$data['uid'])
                    ->orderBy('up_company_name', 'asc')
                    ->groupBy('puser_product_id')
                    ->get();
                $prodct_select_box = "";
		foreach($products as $product){
			$prodct_select_box .= "<option value='".$product->id."'>".$product->name."</option>";
		}
		return $prodct_select_box;
	
	}
	public function epinchargeAjaxCall(){
		$data = Input::all();
                $epincharge = DB::table('users')
                        ->leftjoin('cep_groups','cep_groups.group_id','=','users.group_id')
                        ->leftjoin('cep_product_users','cep_product_users.puser_user_id','=','users.id')
                        ->where('cep_groups.group_code','=',"BO")
                        ->where('cep_product_users.puser_incharge','=',1)
			            ->where('cep_product_users.puser_product_id','=',$data['pid'])
                        ->where('users.status','=',1)
                        ->select('users.id as id', 'users.name as name','users.email as email','users.group_id as gid')
                        ->get();
                $epincharge_select_box = "<option value='' selected>Select</option>";
                foreach($epincharge as $epi){
                        $epincharge_select_box .= "<option value='".$epi->id."'>".$epi->name." ( ".$epi->email." ) </option>";
                }
                return $epincharge_select_box;

	}
	public function clientinchargeAjaxCall(){
                $data = Input::all();
                $clincharge = DB::table('users')
                        ->leftjoin('cep_groups','cep_groups.group_id','=','users.group_id')                     
                        ->where('cep_groups.group_code','=',"CM")
                        ->where('users.user_created_by','=',$data['uid'])
                        ->where('users.status','=',1)
                        ->select('users.id as id', 'users.name as name','users.email as email','users.group_id as gid')
                        ->get();

//		print_r ($clincharge);
                $clincharge_select_box = "<option value='' selected>Select</option>";
                foreach($clincharge as $epi){
                        $clincharge_select_box .= "<option value='".$epi->id."'>".$epi->name." ( ".$epi->email." ) </option>";
                }
                return $clincharge_select_box; 

        }


}
