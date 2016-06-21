<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepAppointments extends Model {

	//
	const CREATED_AT = "apo_create_date";
	const UPDATED_AT = "apo_update_date";
	protected $table = 'cep_appointments';
	protected $primaryKey = 'apo_id';

	protected $fillable=['apo_client_id','apo_product_id','apo_item_id','apo_ep_incharge_id','apo_client_incharge_id','apo_datetime','apo_subject','apo_description','apo_attachement_id','apo_status'];
	public $timestamps = true;

	public function clientRelationship(){
		return $this->hasOne('App\User','id','apo_client_id');
	}	
	public function productRelationship(){
                return $this->hasOne('App\CepProducts','prod_id','apo_product_id');
        }
	public function epInchargeRelationship(){
                return $this->hasOne('App\User','id','apo_ep_incharge_id');
        }
	public function clientInchargeRelationship(){
                return $this->hasOne('App\User','id','apo_client_incharge_id');
        }

}
