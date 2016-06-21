<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepItemConfigurations extends Model {

	//
	protected $table = "cep_item_configurations";
	protected $primaryKey = "iconf_id";

	public $timestamps = false;
	protected $fillable = ['iconf_id','iconf_product_id','iconf_item_id','iconf_name','iconf_value','iconf_status'];

}
