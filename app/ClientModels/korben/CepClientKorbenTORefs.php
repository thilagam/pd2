<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenTORefs extends Model {

	//
		protected $table = "cep_client_korben_to_refs";
		protected $primaryKey = "to_ref_id";
		protected $fillable = ['to_ref_code_produit', 'to_ref_data', 'to_ref_upload_id'];
	  protected $guarded = ['to_ref_id', 'to_ref_status'];
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
