<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepGroupPermissions extends Model {

	//
	protected $fillable = ['gp_id','gp_perm_id','gp_group_id','gp_permission'];
	public $timestamps = false;

	/* Set Primary key for table  */		
	protected $primaryKey = 'gp_id';

	public function permission()
	{
		return $this->hasOne('App\CepPermissions','perm_id','gp_perm_id');   
	}
	public function group()
	{
		return $this->hasOne('App\CepGroups','group_id','gp_group_id');
	}

	
}
