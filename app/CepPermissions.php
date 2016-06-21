<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepPermissions extends Model {

	//
	protected $table = 'cep_permissions';
	protected $primaryKey = 'prem_id';
	protected $fillable = ['perm_id','perm_keyword','perm_description','perm_status'];
	public $timestamps = false;

}
