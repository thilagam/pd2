<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepEmailMessages extends Model {

	//
	protected $table = "cep_email_messages";
	protected $primaryKey = "em_id";
	public $timestamps = false;

	public $fillable = ['em_id','em_ticket_id','em_type','em_from','em_to','em_variables','em_subject','em_message','em_create_date','em_status','em_attachment'];

	public function userfrom(){
		return $this->hasOne("App\User",'id','em_from');
	}	
	public function userdetails(){
                return $this->hasOne("App\CepUserPlus",'up_user_id','em_from');
	}
	public function getDateTimeAttribute($value){
        	$dt = new \Carbon\Carbon(trim($value));
		return $dt->format('D, d F Y h:i A'); 
    	}

}
