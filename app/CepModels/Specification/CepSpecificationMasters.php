<?php namespace App\CepModels\Specification;

use Illuminate\Database\Eloquent\Model;

class CepSpecificationMasters extends Model {

	//
	protected $table="cep_specification_masters";
	protected $primaryKey="spec_id";

	public $fillable = ['spec_id','spec_type','spec_created_date','spec_created_by','spec_updated_date','spec_updated_by','spec_status'];
	public $timestamps = false;

}
