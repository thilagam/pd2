<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepKeywordTranslations extends Model {

	//
	protected $table = 'cep_keyword_translations';
	protected $primaryKey = 'kwtrans_id';
	protected $fillable=['kwtrans_id','kwtrans_keyword_id','kwtrans_language_code','kwtrans_word','kwtrans_status'];
	public $timestamps = false;
	
   	public function keyword(){
	
    		return $this->hasOne('App\CepKeywords','kw_id','kwtrans_keyword_id');
	   
   	}
   	public function language(){
	   
		return $this->hasOne('App\CepLanguages', 'lang_code', 'kwtrans_language_code');   
	   
   	}	
}
