<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenMorganRefs extends Model {

	//
	protected $table = "cep_client_korben_morgan_refs";
	protected $primaryKey = "morgan_ref_id";
	protected $fillable = ['morgan_ref_code_produit', 'morgan_ref_data', 'morgan_ref_upload_id'];
	protected $guarded = ['morgan_ref_id', 'morgan_ref_status'];
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
