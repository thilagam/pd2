<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepEmailTemplatesPlus extends Model {

	//
	protected $table = "cep_email_templates_plus";
	protected $primaryKey = "etempplus_id";
	public $fillable = ['etempplus_id','etempplus_template_id','etempplus_language_code','etempplus_template_code','etempplus_status'];
	public $timestamps = false;

}
