<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepConfigs extends Model {

	//
	protected $table = 'cep_configs';
	protected $primaryKey = 'conf_id';
	protected $fillable=['conf_id','conf_name','conf_value','conf_status'];
	public $timestamps=false;
}
