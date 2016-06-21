<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenATGens extends Model {

	//
	protected $table = "cep_client_korben_at_gens";
	protected $primaryKey = "at_gen_id";
	protected $fillable = ['at_gen_code_produit', 'at_gen_img_url', 'at_gen_img_count', 'at_gen_data', 'at_gen_download_id'];
	protected $guarded = ['at_gen_id', 'at_gen_status'];
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
