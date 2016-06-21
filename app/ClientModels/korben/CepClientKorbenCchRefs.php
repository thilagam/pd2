<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenCchRefs extends Model {

	//
	protected $table = "cep_client_korben_cch_refs";
	protected $primaryKey = "cch_ref_id";
	protected $fillable = ['cch_ref_code_produit', 'cch_ref_data', 'cch_ref_upload_id'];
	protected $guarded = ['cch_ref_id', 'cch_ref_status']
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
