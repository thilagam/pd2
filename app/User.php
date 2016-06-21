<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password','group_id','user_parent_id','user_max_subaccounts','user_created_by','user_updated_by','user_last_login_date'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token']; 

	public function groups(){
	   return $this->hasOne('App\CepGroups','group_id','group_id');
	}

	public function userPlus(){
	   return $this->hasOne('App\CepUserPlus','up_user_id','id');
	}

	public function productUser(){
	   return $this->hasMany('App\CepProductUsers','puser_user_id','id');
	}
}
