<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepAttachmentFiles extends Model {

	//
	protected $table = "cep_attachment_files";
	protected $primaryKey = "attfiles_id";
	protected $fillable = ['attfiles_id','attfiles_attachment_id','attfiles_type','attfiles_original_name','attfiles_name','attfiles_path','attfiles_created_date','attfiles_created_by','attfiles_status'];

	public $timestamps = false;

}
