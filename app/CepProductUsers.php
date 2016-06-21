<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepProductUsers extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cep_product_users';
	protected $primaryKey = 'puser_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['puser_product_id','puser_user_id','puser_group_id','puser_incharge','puser_status'];

	/**
	 * Function userinfo
	 *
	 * @param
	 * @return
	 */		
	public function user()
	{
		return $this->belongsTo('App\user','puser_user_id','id');
	}

	/**
	 * Function userPlus
	 *
	 * @param
	 * @return
	 */		
	public function userPlus()
	{
		return $this->hasOne('App\CepUserPlus','up_user_id','puser_user_id');
	}

	/**
	 * Function group
	 *
	 * @param
	 * @return
	 */		
	public function group()
	{
		return $this->belongsTo('App\CepGroups','puser_group_id','group_id');
	}

	/**
	 * Function product
	 *
	 * @param
	 * @return
	 */		
	public function product()
	{
		return $this->hasMany('App\CepProducts','prod_id','puser_product_id');
	}

	

}
