<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepProductFtp extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cep_product_ftp';
	protected $primaryKey = 'ftp_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['ftp_product_id',
						   'ftp_host',
						   'ftp_user_name',
						   'ftp_password',
						   'ftp_create_date',
						   'ftp_created_by',
						   'ftp_updated_by',
						   'ftp_status'
						   ];
	
	/**
	 * Function product
	 *
	 * @param
	 * @return
	 */		
	public function product()
	{
			return $this->hasOne('Cepproducts','prod_id','ftp_product_id')	;
	}						  
}
