<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepEmailTemplates extends Model {

	//
	protected $table = "cep_email_templates";
	protected $primaryKey = "etemp_id";
	public $timestamps = false;

	protected $fillable = ['etemp_id','etemp_name','etemp_description','etemp_language_code','etemp_template_code','etemp_status'];
	
	public function languages(){
		return $this->hasOne('App\CepLanguages','lang_code','etemp_language_code');
	}
}
