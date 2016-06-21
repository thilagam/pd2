<?php namespace App\ClientModels\korben;

use Illuminate\Database\Eloquent\Model;

class CepClientKorbenATRefs extends Model {

	//
		protected $table = "cep_client_korben_at_refs";
		protected $primaryKey = "at_ref_id";
		protected $fillable = ['at_ref_code_produit', 'at_ref_data', 'at_ref_upload_id'];
		protected $guarded = ['at_ref_id', 'at_ref_status'];
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
