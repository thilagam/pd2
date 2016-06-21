<?php namespace App\Libraries;

use Auth;
use request;
use Carbon\Carbon; 
use File;

use App\CepEmailTickets;
use App\CepEmailMessages;
use App\CepEmailTemplates;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Services\UploadsManager;
/**
* Emailer class used for sending emails, sending and receving message.
* Keeps track of sending of emails and messages in DB
*/
class EMailer
{
	public $user_id;
	
	public function __construct()
	{	
		$this->user_id = Auth::id();
	}

        /**
         * Function sendEmail
         *
         * @param $email_parameters array contain email parameters
         * @return $template_code->etemp_template_code contain template code of perticular id
         */

	public function sendEmail($email_parameters){
		$user = array(
		         'email'=>$email_parameters['em_email'],
	        	 'name'=>$email_parameters['em_name']
	        );

		// the data that will be passed into the mail view blade template
		$data = array(
			'em_template_content' =>getTemplateCode($email_parameters['em_etemp_id']), 
		);

		// use Mail::send function to send email passing the data and using the $user variable in the closure
		Mail::send('emails.welcome', $email_parameters['em_data'], function($message) use ($user)
		{
			  $message->from($email_parameters['em_sender'], $email_parameters['em_sender_text']);
			  $message->to($email_parameters['em_email'], $email_parameters['em_name'])->subject($email_parameters['em_subject']);
			  if(isset($email_parameter['em_attachment_path']))
				$message->attach($email_parameter['em_attachment_path']);
		});			
		return true;
	}

        /**
         * Function sendMessage
         *
         * @param $email_parameters array contain email parameters
         * @return $template_code->etemp_template_code contain template code of perticular id
         */
	public function sendMessage($email_parameters){
		//Pop out other indexs from email_parameters
		$email_parameters_i = array();
		if($email_parameters['em_ticket_id']){
	        $email_parameters_i = array_only($email_parameters, ['em_type','em_from','em_to','em_variables','em_subject','em_message','em_ticket_id','em_attachment']);  
	        //print_r ($email_parameters_i); exit; 
			CepEmailMessages::create($email_parameters_i);	
			
		}else{

            $email_parameters_i = array_only($email_parameters, ['em_type','em_from','em_to','em_variables','em_subject','em_message','em_attachment']);
			$ticket = CepEmailTickets::create(array('eticket_template_id'=>$email_parameters['eticket_template_id']));
			$email_parameters_i['em_ticket_id'] = $ticket->eticket_id;
			CepEmailMessages::create($email_parameters_i);
		}

//		echo "<pre>";print_r ($email_parameters);print_r ($email_parameters_i);

		return true;
	}



	/**
	 * Function getTemplateCode
	 *
	 * @param $id which email templated is selected
	 * @return $template_code->etemp_template_code contain template code of perticular id
	 */
	public function getTemplateCode($id){
		$template_code = CepEmailTemplates::where("etemp_id",$id)->select("etemp_template_code")->first();
		return $template_code->etemp_template_code;		
	}
}	
