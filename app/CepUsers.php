<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class CepUsers extends Model implements AuthenticatableContract {

        use Authenticatable, CanResetPassword;

	//
	protected $table = 'cep_users';
	protected $fillable = ['user_id','user_name','user_email','user_password','user_group_id'];
	public $timestamps = false;

}
