<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenCchGens extends Model {

	//
	protected $table = "cep_client_korben_cch_gens";
	protected $primaryKey = "cch_gen_id";
	protected $fillable = ['cch_gen_code_produit', 'cch_gen_img_url', 'cch_gen_img_count', 'cch_gen_data', 'cch_gen_download_id'];
	protected $guarded = ['cch_gen_id', 'cch_gen_status'];
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
