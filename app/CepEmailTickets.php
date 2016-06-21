<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CepEmailTickets extends Model {

	//
	protected $table = "cep_email_tickets";
	protected $primaryKey = "eticket_id";
	public $timestamps = false;

	protected $fillable = ['eticket_id','eticket_template_id','eticket_status'];

}
