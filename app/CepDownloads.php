<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepDownloads extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cep_downloads';
	protected $primaryKey = 'download_id';
    public $timestamps= false;
	//const CREATED_AT = "download_date";
	//const UPDATED_AT = "download_update_date";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [	'download_by',
							'download_date',
							'download_type',
							'download_name',
							'download_description',
							'download_url',
							'download_client_id',
							'download_product_id',
							'download_item_id',
							'download_status'
						  ];

							public function downloadlogs(){
										return $this->hasOne("App\CepDownloadLogs", 'dlog_download_id', 'download_id');
							}

							public function userby(){
									 return $this->hasOne("App\CepUserPlus", 'up_user_id', 'download_by');
							}

							public function clientby(){
										 return $this->hasOne("App\CepUserPlus", 'up_user_id', 'download_client_id');
							}

							public function productname(){
										return $this->hasOne("App\CepProducts", 'prod_id', 'download_product_id');
							}

							public function itemname(){
										return $this->hasOne("App\CepItems", 'item_id', 'download_item_id');
							}

}
