<?php namespace App\Http\Controllers;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\CepEmailMessages;
use App\CepEmailTemplates;
use Auth;
use DB;
use Input;
use Request;
use App\User;
use App\CepUserPlus;
use Validator;
use App\Libraries\EMailer;
use App\Libraries\CheckAccessLib; 

use App\CepAttachmentFiles;
use App\Libraries\FileManager;


class EMailerController extends Controller {

	protected $folder,$unread_count,$uid,$send_message,$configs,$checkaccess;

	public function __construct(\Illuminate\Http\Request $request)
	{
	    	$this->middleware('auth');
		    $this->folder = "inbox";
            $this->unread_count = CepEmailMessages::where('em_read_status',0)->where('em_to',Auth::id())->where('em_status',1)->count();
	    	$this->permit=$request->attributes->get('permit');
	    	$this->configs=$request->attributes->get('configs');		
	    	$this->send_message = new EMailer;
	    	$this->checkaccess = new CheckAccessLib;
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
                $uid = Auth::id();
		$pagination_value = $this->configs->email_default_pagination_value;
		$query = CepEmailMessages::where('em_status',1)
					->where('em_to',$uid)
					->orderBy('em_create_date','desc')
					->select(DB::raw('*,DATE_FORMAT(em_create_date,"%a,%d %M %Y %h:%i %p") as em_dt'));
		
		$mail_count = $query->count();
		$mailbox = $query->simplePaginate($this->configs->email_default_pagination_value);
		$unread_count = $this->unread_count;
		$folder = $this->folder; 
		
		return view("mailbox.index",compact('mailbox','folder','unread_count','pagination_value','mail_count'));
	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$all_users = $this->getMailUsers();
                $unread_count = $this->unread_count;
                $folder = 'compose';
		return view("mailbox.create",compact('folder','unread_count','all_users'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$message_array = array();
                $message = Request::all();
                $validate = Validator::make($message,[
                            'em_to' => 'required',
 			    'em_subject' => 'required',
			    'em_message' => 'required',	
                 ]);
                if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());
                }

        if(Input::hasFile('files')){  
            $files=Input::file('files');      
            $message_array['em_attachment'] = $this->attachment->createAttachment(array('att_type'=>'email'));       
            foreach($files as $key=>$fl){
                    //echo "<pre>"; print_r ($appointments['files'][$key]); //exit;
                    $this->attachment->uploadAttachmentFiles($fl,$message_array['em_attachment']);
            }
        } 

		$message_array['em_subject'] = $message['em_subject'];
       	$message_array['em_message'] = $message['em_message'];
		$message_array['eticket_template_id'] = $this->configs->email_default_custom_template_id;	
		$message_array['em_from'] = Auth::id();	
		$message_array['em_ticket_id'] = 0;
		$message_array['em_type'] = 0;
		$message_array['em_variables'] = '';
		foreach($message['em_to'] as $to){
			$message_array['em_to'] = $to;
			$this->send_message->sendMessage($message_array);			
		}		
		return redirect('mailbox');
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
		 $uid = Auth::id();
                $folder = $id;
                $unread_count = $this->unread_count;
                $mail_count = 0;
                $mailbox = "";
                $pagination_value = $this->configs->email_default_pagination_value;
                switch(true){
                    case (strcmp($id,'sent') == 0):
                $query = CepEmailMessages::where('em_status',1)->where('em_from',$uid)->select(DB::raw('*,DATE_FORMAT(em_create_date,"%a,%d %M %Y %h:%i %p") as em_dt'))->orderBy('em_create_date','desc');
                $mail_count = $query->count();
                $mailbox = $query->simplePaginate($pagination_value);
                $mailbox->setPath('sent');
                                break;

                    case (strcmp($id,'draft') == 0):
                        $query = CepEmailMessages::where('em_status',2)->select(DB::raw('*,DATE_FORMAT(em_create_date,"%a,%d %M %Y %h:%i %p") as em_dt'))->orderBy('em_create_date','desc');
                $mail_count = $query->count();
                $mailbox = $query->simplePaginate($pagination_value);
                $mailbox->setPath('draft');
                                break;

                    case (strcmp($id,'trash') == 0):
                        $query = CepEmailMessages::where('em_status',3)->select(DB::raw('*,DATE_FORMAT(em_create_date,"%a,%d %M %Y %h:%i %p") as em_dt'))->orderBy('em_create_date','desc');
                $mail_count = $query->count();
                $mailbox = $query->simplePaginate($pagination_value);
                $mailbox->setPath('draft');
                                break;

                    default:
                        return redirect('mailbox');
                                break;
                }
                return view("mailbox.index",compact('mailbox','folder','unread_count','pagination_value','mail_count'));
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
                $message_array = array();
                $message = Request::only('em_subject','em_message','em_ticket_id','em_to');
                $validate = Validator::make($message,[
                            'em_to' => 'required',
                            'em_subject' => 'required',
                            'em_message' => 'required',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }

        if(Input::hasFile('files')){  
            $files=Input::file('files');      
            $message_array['em_attachment'] = $this->attachment->createAttachment(array('att_type'=>'email'));       
            //exit;
            foreach($files as $key=>$fl){
                    //echo "<pre>"; print_r ($appointments['files'][$key]); //exit;
                    $this->attachment->uploadAttachmentFiles($fl,$message_array['em_attachment']);
            }
        } 


                $message_array['em_subject'] = $message['em_subject'];
                $message_array['em_message'] = $message['em_message'];
                $message_array['eticket_template_id'] = $this->configs->email_default_custom_template_id;
                $message_array['em_from'] = Auth::id();
                $message_array['em_ticket_id'] = $message['em_ticket_id'];
                $message_array['em_type'] = 0;
                $message_array['em_variables'] = '';
                //print_r ($message_array); //exit;
                foreach($message['em_to'] as $to){
                        $message_array['em_to'] = $to;
                        $this->send_message->sendMessage($message_array);
                }
                return redirect('mailbox');

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
         * Get Message as per $id and update read status as read.
         *
         * @param  int  $id
	 * @param  int $bool
         * @return Response
         */

	public function message($id,$bool)
	{
        if(!$this->checkaccess->messageAccessCheck($id))
			return redirect('accessDenied');

		$user = CepUserPlus::where('up_user_id',Auth::id())->select('up_default_language')->first();	
		
		if(strcmp($bool,"inbox") == 0)
			CepEmailMessages::where('em_id',$id)->update(array('em_read_status'=>1));
		$unread_count = $this->unread_count;
		$folder = "message";
		$query = CepEmailMessages::select(DB::raw('cep_email_messages.*,cep_email_tickets.*,cep_email_templates_plus.etempplus_template_code,A.up_first_name as from_first_name,B.email as from_email,C.up_first_name as to_first_name,D.email as to_email,A.up_profile_image as from_profile_image'))  
				->leftjoin('cep_email_tickets','eticket_id','=','em_ticket_id')
				->leftjoin('cep_email_templates','eticket_template_id','=','etemp_id')
				->leftjoin('cep_email_templates_plus','etemp_id','=','etempplus_template_id')
				->leftjoin('cep_user_plus as A','A.up_user_id','=','em_from')	
				->leftjoin('users as B','B.id','=','em_from')
                ->leftjoin('cep_user_plus as C','C.up_user_id','=','em_to')
                ->leftjoin('users as D','D.id','=','em_to')
				->where('em_id',$id)
				->where('etempplus_language_code',$user['up_default_language']);

		$mailbox_count = $query->count();
        $mailbox = "";
		if($mailbox_count == 0){
			$mailbox = $query->orWhere('etempplus_language_code','en')->first(); // Default language is en
		}else{
			$mailbox = $query->first();
		}
 
//		echo $mailbox; exit;
		$message_new = "";		
		if(!empty($mailbox['em_variables'])){
			$mailbox['em_message'] = $mailbox->etempplus_template_code;
                	foreach(json_decode($mailbox['em_variables']) as $key=>$emvar){
				$mailbox['em_message'] = str_replace($key,$emvar,$mailbox['em_message']);
			}
		}else{
                     $mailbox['em_message'] = str_replace("ET-MESSAGE",$mailbox->em_message,$mailbox->etempplus_template_code);
		}

		//echo htmlentities($mailbox['em_message']); exit;
		$oldmailbox = CepEmailMessages::where('em_create_date','<',$mailbox->em_create_date)
					->where('em_ticket_id','=',$mailbox->em_ticket_id)
					->orderBy('em_create_date','desc')
					->select(DB::raw('*,DATE_FORMAT(em_create_date,"%a,%d %M %Y %h:%i %p") as em_dt'))
					->get();
//		print_r ($oldmailbox);
//		exit;

		$email_attachment = CepAttachmentFiles::where('attfiles_attachment_id',$mailbox['em_attachment'])->get();			

		return view("mailbox.show",compact('mailbox','folder','unread_count','bool','oldmailbox','email_attachment'));
	}

        /**
         * Remove the specified resource from inbox to trash.
         *
         * @param  int  $id
         * @return Response
         */
	public function deleteMessage($id){
		CepEmailMessages::where('em_id',$id)->update(array('em_status'=>3));
		return redirect('mailbox');
	}

        /**
         * Remove the specified resource from inbox to trash.
         *
         * @param  int  $id
         * @return Response
         */
        public function draftMessage($id){
                CepEmailMessages::where('em_id',$id)->update(array('em_status'=>2));
                return redirect('mailbox');
        }


        /**
         * Reply to email you want.
         *
         * @param  int  $id
         * @return Response
         */
        public function replyMessage($id){

        if(!$this->checkaccess->messageAccessCheck($id))
			return redirect('accessDenied');

		$message = CepEmailMessages::with('userfrom','userdetails')->where('em_id',$id)->first();
                $unread_count = $this->unread_count;
                $folder = 'reply';
                return view("mailbox.reply",compact('folder','unread_count','message'));

        }

	
        /**
         * get all email users specific to user login.
         *
         * @param  int  $id
         * @return Response
         */
	public function getMailUsers(){
		$mail_users = array();
		$user = User::with('groups')->find(Auth::id());
		$query = "";
		$group_array = array();
		$user_array = array();
                $query = DB::table('users')->leftjoin('cep_user_plus','id','=','up_user_id')
                                        ->leftjoin('cep_groups','cep_groups.group_id','=','users.group_id');

		if((strcmp($user->groups->group_code,"SA") == 0 || strcmp($user->groups->group_code,'DEV') == 0)){ // Super Admin & Developer
		                $group_array = array('SA','BO','CL','PA','CM','DEV');
		}elseif(strcmp($user->groups->group_code,"BO") == 0){  						   // Bo User
				$group_array = array('SA','BO','PA');
				$user_array = $this->getMailOtherUsers(); 
		}elseif(strcmp($user->groups->group_code,"CL") == 0){						   // Clients
                                $group_array = array('SA');
                                $user_array = $this->getMailOtherUsers(); 
		}elseif(strcmp($user->groups->group_code,"PA") == 0){						   // Prod Admin
                               $group_array = array('SA','BO');
                                $user_array = $this->getMailOtherUsers(); 
		}elseif(strcmp($user->groups->group_code,"CM") == 0){						   // Client Manager
                               $group_array = array('SA');	
				$user_array = $this->getMailOtherUsers(); 
		} 
                 
                                        $query->whereIn('group_code',$group_array);
					$query->orWhereIn('id',$user_array);
                                        $query->where('id','!=',Auth::id());
		                        $query->where("status",1);
					$query->select('id','cep_user_plus.up_first_name','cep_user_plus.up_last_name','email');
                                        $all_users = $query->get(); 
//		print_r ($all_users); exit;
		foreach($all_users as $au)
			if(!in_array($au->id,$mail_users) && $au->id != Auth::id())
				$mail_users[$au->id] = $au->up_first_name." ".$au->up_last_name." (".$au->email.")";	
		return $mail_users;
	}

        /**
         * get remaining email users specific to client login.
         *
         * @param  int  $id
         * @return Response
         */
	public function getMailOtherUsers(){
		$id = Auth::id();
		$product = DB::table('cep_product_users')
				  ->select('up_user_id as id','up_company_name','prod_id','prod_name','item_id','item_name','item_url')
			          ->leftjoin('cep_groups', 'cep_groups.group_id', '=', 'cep_product_users.puser_group_id')
			          ->leftjoin('cep_user_plus', 'cep_user_plus.up_user_id', '=', 'cep_product_users.puser_user_id')
			          ->leftjoin('cep_products', 'cep_products.prod_id', '=', 'cep_product_users.puser_product_id')
			          ->leftjoin('cep_items','item_product_id','=','prod_id')
	    	  	          ->whereIn('puser_product_id', function($query) use ($id)
	    		          {
	       			        $query->select('puser_product_id')
	                                      ->from('cep_product_users')
	                                      ->whereRaw('cep_product_users.puser_user_id = '.$id)
	                                      ->groupBy('puser_product_id');
	                          })
	                          ->get();
		$clients=array();
		foreach($product as $key=>$prod)
			if(!in_array($prod->id,$clients))
				$clients[$key] = $prod->id;
		return ($clients);
	}
}
