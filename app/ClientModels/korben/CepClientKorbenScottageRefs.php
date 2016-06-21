<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenScottageRefs extends Model {

	//
	protected $table = "cep_client_korben_scottage_refs";
	protected $primaryKey = "scottage_ref_id";
	protected $fillable = ['scottage_ref_code_produit', 'scottage_ref_data', 'scottage_ref_upload_id'];
	protected $guarded = ['scottage_ref_id', 'scottage_ref_status'];
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
