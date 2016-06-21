<?php namespace App\ClientModels;

use Illuminate\Database\Eloquent\Model;

class CepClientCarollRef extends Model {

	//Init
	public $table = "cep_client_carol_ref";
	public $primaryKey = 'carol_ref_id';
	protected $fillable=[
						  'carol_ref_id',
						  'carol_ref_reference',
						  'carol_ref_reference_color',
						  'carol_ref_colref',
						  'carol_ref_color_name',
						  'carol_ref_department',
						  'carol_ref_composition',
						  'carol_ref_material',
						  'carol_ref_family',
						  'carol_ref_subfamily',
						  'carol_ref_forme',
						  'carol_ref_sleeves',
						  'carol_ref_col',
						  'carol_ref_descriptif_court',
						  'carol_ref_sasid',
						  'carol_ref_create_date',
						  'carol_ref_created_by',
						  'carol_ref_processed',
						  'carol_ref_process_date',
						  'carol_ref_processed_by',
						  'carol_ref_status'

						];

	public $timestamps=false;

}