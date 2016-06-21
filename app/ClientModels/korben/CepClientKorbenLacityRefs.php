<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenLacityRefs extends Model {

	//
	protected $table = "cep_client_korben_lacity_refs";
	protected $primaryKey = "lacity_ref_id";
	protected $fillable = ['lacity_ref_code_produit', 'lacity_ref_data', 'lacity_ref_upload_id'];
	protected $guarded = ['lacity_ref_id', 'lacity_ref_status'];
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
