<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenMorganUkRefs extends Model {

	//
	protected $table = "cep_client_korben_morgan_uk_refs";
	protected $primaryKey = "morgan_uk_ref_id";
	protected $fillable = [ 'morgan_uk_ref_code_produit', 'morgan_uk_ref_data', 'morgan_uk_ref_upload_id'];
	protected $guarded = ['morgan_uk_ref_id', 'morgan_uk_ref_status'];
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
