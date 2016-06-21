<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepActivityTemplates extends Model {

	//
	protected $table="cep_activity_templates";
	protected $primaryKey="actmp_id";
	public $timestamps = false;
	public $fillable = ['actmp_id','actmp_name','actmp_description','actmp_variables','actmp_status'];


}
