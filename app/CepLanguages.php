<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepLanguages extends Model {

	//
	protected $table = 'cep_languages';
	protected $primaryKey = 'lang_id';
    protected $fillable=['lang_name','lang_code','lang_status'];
	public $timestamps = false;

}
