<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenTOGens extends Model {

	//
	protected $table = "cep_client_korben_to_gens";
	protected $primaryKey = "to_gen_id";
	protected $fillable = ['to_gen_code_produit', 'to_gen_img_url', 'to_gen_img_count', 'to_gen_data', 'to_gen_download_id'];
	protected $guarded = ['to_gen_id', 'to_gen_status'];
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
