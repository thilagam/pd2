<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenMorganHofRefs extends Model {

	//
	protected $table = "cep_client_korben_morgan_hof_refs";
	protected $primaryKey = "morgan_hof_ref_id";
	protected $fillable = [ 'morgan_hof_ref_code_produit', 'morgan_hof_ref_data', 'morgan_hof_ref_upload_id'];
	protected $guarded = ['morgan_hof_ref_id', 'morgan_hof_ref_status'];
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
