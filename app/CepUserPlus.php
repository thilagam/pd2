<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepUserPlus extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cep_user_plus';
	protected $primaryKey = 'up_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['up_user_id','up_first_name', 'up_last_name', 'up_initial','up_gender','up_dob','up_about_user',
						   'up_company_name','up_designation','up_city','up_country_code','up_about_company',
						   'up_profile_image','up_alerts','up_email_alerts','up_status'];
	/**
	 * Function user
	 * Define a one-to-one relationship with user table 
	 * @return object
	 */		
	public function user()
	{
		return $this->hasOne('App\User','id','up_user_id');
	}

	// public static function create(array $attributes)
	// {
	//     var_dump($attributes);
	//     $model = new static($attributes);

	//     dd($model);

	//     $model->save();

	//     return $model;
	// }

	/**
	 * Function country
	 *
	 * @param
	 * @return
	 */		
	public function country()
	{
		return $this->hasOne('App\CepCountry','country_id','up_country_code');
	}

}
