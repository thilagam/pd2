<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenBnbRefs extends Model {

	//
	protected $table = "cep_client_korben_bnb_refs";
	protected $primaryKey = "bnb_ref_id";
	protected $fillable = ['bnb_ref_code_produit', 'bnb_ref_data', 'bnb_ref_upload_id'];
	protected $guarded = ['bnb_ref_id', 'bnb_ref_status'];
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
