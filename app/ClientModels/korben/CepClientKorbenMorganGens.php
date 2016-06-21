<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenMorganGens extends Model {

	//
	protected $table = "cep_client_korben_morgan_gens";
	protected $primaryKey = "morgan_gen_id";
	protected $fillable = ['morgan_gen_code_produit', 'morgan_gen_img_url', 'morgan_gen_img_count', 'morgan_gen_data', 'morgan_gen_download_id'];
	protected $guarded = ['morgan_gen_id', 'morgan_gen_status'];
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
