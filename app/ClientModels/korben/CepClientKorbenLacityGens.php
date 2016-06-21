<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenLacityGens extends Model {

	//
	protected $table = "cep_client_korben_lacity_gens";
	protected $primaryKey = "lacity_gen_id";
	protected $fillable = ['lacity_gen_code_produit', 'lacity_gen_img_url', 'lacity_gen_img_count', 'lacity_gen_data', 'lacity_gen_download_id'];
	protected $guarded = ['lacity_gen_id',, 'lacity_gen_status']
	public $timestamps = false;

	/**
	* Get the fillable attributes for the model.
	*
	* @return array
	*/
	public function getFillable()
	{
			return $this->fillable;
	}

}
