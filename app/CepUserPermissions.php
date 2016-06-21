<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepUserPermissions extends Model {

	//
	protected $table = 'cep_user_permissions';
	protected $primaryKey = 'uprem_id';
	protected $fillable = ['uprem_id','uperm_user_id','uperm_enabled','uperm_disabled','uperm_status'];
	public $timestamps=false;

	public function user()
	{
		return $this->hasOne('App\User','id','uperm_user_id');
	}

	public function userPlus()
	{
		return $this->hasOne('App\CepUserPlus','up_user_id','uperm_user_id');
	}
}
