<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenBnbGens extends Model {

	//
	protected $table = "cep_client_korben_bnb_gens";
	protected $primaryKey = "bnb_gen_id";
	protected $fillable = [ 'bnb_gen_code_produit', 'bnb_gen_img_url', 'bnb_gen_img_count', 'bnb_gen_data', 'bnb_gen_download_id'];
	protected $guarded = ['bnb_gen_id', 'bnb_gen_status'];
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
