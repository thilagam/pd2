<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepAttachments extends Model {

	//
	protected $table="cep_attachments";
	protected $fillable = ['att_id','att_type','att_status'];
	protected $primaryKey = "att_id";

	public $timestamps = false;

}
