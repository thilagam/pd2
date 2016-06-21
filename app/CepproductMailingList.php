<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepProductMailingList extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cep_product_mailing_list';
	protected $primaryKey = 'ml_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['ml_id',
						   'ml_email',
						   'ml_product_id',
						   'ml_created_by',
						   'ml_updated_by',
						   'ml_status'
						   ];

}
