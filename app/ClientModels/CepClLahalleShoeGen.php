<?php namespace App\ClientModels;

use Illuminate\Database\Eloquent\Model;

class CepClLahalleShoeGen extends Model {

	//Init
	public $table = "cep_cl_lahalle_shoe_gen";
	public $primaryKey = 'lahs_id';
	protected $fillable=[
						  'lahs_id',
						  'lahs_nomod',
						  'lahs_reference',
						  'lahs_descriptif',
						  'lahs_file_url',
						  'lahs_reference_folder',
						  'lahs_ref_image_count',
						  'lahs_create_date',
						  'lahs_created_by',
						  'lahs_data',
						  'lahs_export_filename',
						  'lahs_export_status',
						  'lahs_export_date',
						  'lahs_status'
						];
	public $timestamps=false;

}

  