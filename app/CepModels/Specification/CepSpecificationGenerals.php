<?php namespace App\CepModels\Specification;

use Illuminate\Database\Eloquent\Model;

class CepSpecificationGenerals extends Model {

	//
	protected $table = "cep_specification_generals";
	protected $primaryKey = "specgen_id";

	public $timestamps = false;
	public $fillable = ['specgen_id','specgen_spec_id','specgen_description','specgen_url','specgen_status','specgen_language_code'];

	
   	public function language(){
	 	return $this->hasOne('App\CepLanguages', 'lang_code', 'specgen_language_code');   
	}
}
