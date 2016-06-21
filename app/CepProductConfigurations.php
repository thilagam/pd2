<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepProductConfigurations extends Model {

	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cep_product_configurations';
	protected $primaryKey = 'pconf_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['pconf_product_id',
						   'pconf_item_id',
						   'pconf_type',
						   'pconf_path',
						   'pconf_template',
						   'pconf_reference_id',
						   'pconf_created_by',
						   'pconf_updated_by',
						   'pconf_status'
						   ];

	/**
	 * Function product
	 *
	 * @param
	 * @return
	 */		
	public function product()
	{
		return $this->hasOne('CepProducts','prod_id','pconf_product_id');
	}

}
