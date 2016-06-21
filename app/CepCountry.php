<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepCountry extends Model {

	//
	protected $table = 'cep_countries';
	protected $fillable=['country_id','country_name','country_code','country_iso','country_currency','country_language_code','country_currency_symbol'];
	public $timestamps = false;
	/* Set Primary key for table  */		
	protected $primaryKey = 'country_id';
	
	public function language(){
	   return $this->hasOne('App\CepLanguages','lang_code','country_language_code');
	}

}
