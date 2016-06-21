<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenScottageGens extends Model {

	//
	protected $table = "cep_client_korben_scottage_gens";
	protected $primaryKey = "scottage_gen_id";
	protected $fillable = ['scottage_gen_code_produit', 'scottage_gen_img_url', 'scottage_gen_img_count', 'scottage_gen_data', 'scottage_gen_download_id'];
	protected $guarded = ['scottage_gen_id', 'scottage_gen_status'];
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
