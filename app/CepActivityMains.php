<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepActivityMains extends Model {

	//
	protected $table = "cep_activity_mains";
	protected $primaryKey = "act_id";
	public $fillable = ['act_id',	'act_template_id', 'act_by','act_product_id', 'act_item_id', 'act_client_id', 'act_datetime', 'act_status', 'act_variables'];
	public $timestamps = false;

}
