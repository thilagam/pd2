<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepDownloadLogs extends Model {

	//
	public $table = "cep_download_logs";
	public $primaryKey = 'dlog_id';
	public $timestamps = false;
	protected $fillable = ['dlog_id','dlog_download_id','dlog_by','dlog_time'];


	public function userby(){
			return $this->hasOne("App\CepUserPlus", 'up_user_id', 'dlog_by');
	}

}
