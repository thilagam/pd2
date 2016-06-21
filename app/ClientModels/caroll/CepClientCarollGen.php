<?php namespace App\ClientModels;

use Illuminate\Database\Eloquent\Model;

class CepClientCarollGen extends Model {

	//Init
	public $table = "cep_client_carol_gen";
	public $primaryKey = 'carol_gen_id';
	protected $fillable=[
						  'carol_gen_id',
						  'carol_gen_reference',
						  'carol_gen_sasid',
						  'carol_gen_file_url',
						  'carol_gen_ref_folder',
						  'carol_gen_image_count',
						  'carol_gen_create_date',
						  'carol_gen_created_by',
						  'carol_gen_data',
						  'carol_gen_export_status',
						  'carol_gen_export_by',
						  'carol_gen_date',
						  'carol_gen_status'
						];
						
	public $timestamps=false;

}