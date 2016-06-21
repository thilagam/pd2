<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepBreadcrumbs extends Model {

	//
	protected $table="cep_breadcrumbs";
	protected $primaryKey = "breadcrumb_id";

  protected $fillable=['breadcrumb_name','breadcrumb_page_title','breadcrumb_description','breadcrumb_module_id','breadcrumb_url'];
	public $timestamps = false;

	public function modules(){
		return $this->hasOne('App\CepModules','mod_id','breadcrumb_module_id');
	}

}
