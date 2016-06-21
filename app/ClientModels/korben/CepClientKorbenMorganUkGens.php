<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenMorganUkGens extends Model {

	//
	protected $table = "cep_client_korben_morgan_uk_gens";
	protected $primaryKey = "morgan_uk_gen_id";
	protected $fillable = ['morgan_uk_gen_code_produit', 'morgan_uk_gen_img_url', 'morgan_uk_gen_img_count', 'morgan_uk_gen_data', 'morgan_uk_gen_download_id'];
	protected $guarded = ['morgan_uk_gen_id', 'morgan_uk_gen_status'];
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
