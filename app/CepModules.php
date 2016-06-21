<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepModules extends Model {

	//
	protected $table = 'cep_modules';
	protected $primaryKey = 'mod_id';
	protected $fillable=['mod_id','mod_name','mod_url','mod_status'];
	public $timestamps = false;
}
