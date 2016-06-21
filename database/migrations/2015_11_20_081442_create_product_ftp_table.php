<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFtpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cep_product_ftp', function(Blueprint $table)
		{
			$table->increments('ftp_id');
			$table->integer('ftp_product_id');
			$table->string('ftp_host',45)->nullable();
			$table->string('ftp_username',45)->nullable();
			$table->string('ftp_password',70)->nullable();
			$table->timestamps();
			$table->double('ftp_created_by',20,0);
			$table->double('ftp_updated_by',20,0)->nullable();
			$table->tinyInteger('frp_status')->default(1);

			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cep_product_ftp');
	}

}
