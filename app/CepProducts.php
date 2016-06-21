<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepProducts extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cep_products';
	protected $primaryKey = 'prod_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['prod_name','prod_created_by','prod_updated_by','prod_status'];

	/**  
	*  The One to one relationship to FTP table 
	*
	* 
	*/		
	public function ftp()
	{
		return $this->hasOne('App\CepProductFtp','ftp_product_id','prod_id');
	}

	/**
	 * Function configurations
	 *
	 * @param
	 * @return
	 */		
	public function configurations()
	{
		return $this->hasMany('App\CepProductConfigurations','pconf_product_id','prod_id');
	}

	/**
	 * Function users
	 *
	 * @param
	 * @return
	 */		
	public function users()
	{
		return $this->hasMany('App\CepProductUsers','puser_product_id','prod_id');
	}

}
