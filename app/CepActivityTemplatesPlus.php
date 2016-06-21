<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepActivityTemplatesPlus extends Model {

	//
	protected $table = "cep_activity_templates_plus";
	protected $primaryKey = "actmpplus_id"; 
	public $timestamps = false;
	public $fillable = ['actmpplus_id','actmpplus_template_id','actmpplus_language_code','actmpplus_type','actmpplus_template','actmpplus_status'];
}
