<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepItems extends Model {

	//
	const CREATED_AT = "item_create_date";
	const UPDATED_AT = "item_update_date";
	protected $table = "cep_items";
	protected $primaryKey = "item_id";

	protected $fillable = ['item_id','item_product_id','item_name','item_info','item_url','','item_translation_id','item_create_date','item_created_by','item_update_date','item_updated_by','item_status'];
	
	public $timestamps = true;
}
