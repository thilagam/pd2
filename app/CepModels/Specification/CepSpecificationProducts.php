<?php namespace App\CepModels\Specification;

use Illuminate\Database\Eloquent\Model;

class CepSpecificationProducts extends Model {

	//
	protected $table = "cep_specification_products";
	protected $primaryKey = "specprod_id";

	public $fillable = ['specprod_id','specprod_spec_id','specprod_product_id','specprod_item_id','specprod_url','specprod_usage','specprod_attachment_id','specprod_description','specprod_technical_info','specprod_reference_id','specprod_status'];
	public $timestamps = false;


	public function productdtl(){
		return $this->hasOne("App\CepProducts","prod_id","specprod_product_id");
	}


	public function language(){
	 	return $this->hasOne('App\CepLanguages', 'lang_code', 'specprod_language_code');   
	}
}
