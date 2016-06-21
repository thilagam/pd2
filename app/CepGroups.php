<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepGroups extends Model {

	//
	protected $fillable = ['group_name', 'group_description', 'group_code'];
	public $timestamps=false;

	/**
	 * Function usersByGroup
	 *
	 * @param
	 * @return
	 */		
	public function users()
	{
		 return $this->hasMany('App\User','group_id','group_id');
	}

	

}
