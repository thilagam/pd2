<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepUploads extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cep_uploads';
	protected $primaryKey = 'upload_id';

	const CREATED_AT = "upload_date";
	const UPDATED_AT = "upload_update_date";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [	'upload_name',
							'upload_by',
							'upload_date',
							'upload_name',
							'upload_type',
							'upload_original_name',
							'upload_reference_column',
							'upload_description',
							'upload_url',
							'upload_client_id',
							'upload_product_id',
							'upload_item_id',
							'upload_verification_status',
							'upload_verification_by',
							'upload_verification_msg',
							'upload_status'
						  ];

	public function uploadlogs(){
				return $this->hasOne("App\CepUploadLogs", 'uplog_upload_id', 'upload_id');
	}

	public function userby(){
			 return $this->hasOne("App\CepUserPlus", 'up_user_id', 'upload_by');
	}

	public function verifyby(){
			return $this->hasOne("App\CepUserPlus", 'up_user_id', 'upload_verification_by');
	}

	public function clientby(){
				 return $this->hasOne("App\CepUserPlus", 'up_user_id', 'upload_client_id');
	}

	public function productname(){
				return $this->hasOne("App\CepProducts", 'prod_id', 'upload_product_id');
	}

	public function itemname(){
				return $this->hasOne("App\CepItems", 'item_id', 'upload_item_id');
	}

}
