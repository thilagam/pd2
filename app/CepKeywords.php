<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepKeywords extends Model {

	//
	protected $table = 'cep_keywords';
	protected $primaryKey = 'kw_id';
	protected $fillable=['kw_id','kw_name','kw_module_id','kw_status'];
	public $timestamps = false;
	
    	public function module()
    	{
        	return $this->hasOne('App\CepModules', 'mod_id', 'kw_module_id');
    	}	
}
