<?php namespace App\ClientModels;

use Illuminate\Database\Eloquent\Model;

class CepClientCarollPdn extends Model {

	//Init
	public $table = "cep_client_carol_pdn";
	public $primaryKey = 'carol_pdn_id';
	protected $fillable=[
						  'carol_pdn_id',
						  'carol_pdn_modal_name',
						  'carol_pdn_reference',
						  'carol_pdn_color_reference',
						  'carol_pdn_composition_doubloon',
						  'carol_pdn_profit_felt_prod',
						  'carol_pdn_ganse',
						  'carol_pdn_length',
						  'carol_pdn_create_date',
						  'carol_pdn_created_by',
						  'carol_pdn_processed',
						  'carol_pdn_process_date',
						  'carol_pdn_status',
						];

	public $timestamps=false;

}

  