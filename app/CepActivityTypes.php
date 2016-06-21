<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepActivityTypes extends Model {

	//
	protected $table="cep_activity_types";
	protected $primaryKey="acttype_id";
	public $timestamps = false;
	public $fillable=['acttype_id','acttype_name','acttype_description','acttype_icon','acttype_status']; 

	
}
