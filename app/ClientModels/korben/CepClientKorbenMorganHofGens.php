<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenMorganHofGens extends Model {

	//
	protected $table = "cep_client_korben_morgan_hof_gens";
	protected $primaryKey = "morgan_hof_gen_id";
	protected $fillable = ['morgan_hof_gen_code_produit', 'morgan_hof_gen_img_url', 'morgan_hof_gen_img_count', 'morgan_hof_gen_data', 'morgan_hof_gen_download_id'];
	protected $guarded = ['morgan_hof_gen_id', 'morgan_hof_gen_status'];
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
