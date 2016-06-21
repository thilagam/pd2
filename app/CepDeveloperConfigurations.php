<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepDeveloperConfigurations extends Model {

	//
	protected $table = "cep_developer_configurations";
	protected $primaryKey = "dconf_id";

	public $timestamps = false;
	protected  $fillable = ['dconf_id','dconf_product_id','dconf_name','dconf_value','dconf_status'];


}
