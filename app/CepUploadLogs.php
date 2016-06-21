<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepUploadLogs extends Model {

	//
	protected $table = "cep_upload_logs";
	protected $primaryKey = "uplog_id";
	public $timestamps = false;

	public $fillable = ['uplog_id','uplog_upload_id','uplog_logs','uplog_status','uplog_check_upload','uplog_check_status'];



}
