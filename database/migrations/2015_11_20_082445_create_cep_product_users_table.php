<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCepProductUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cep_product_users', function(Blueprint $table)
		{
			$table->increments('puser_id');
			$table->integer('puser_product_id');
			$table->double('puser_user_id',20,0);
			$table->integer('puser_group_id');
			$table->tinyInteger('puser_incharge')->default(0);
			$table->timestamps();
			$table->tinyInteger('puser_status')->default(1);
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cep_product_users');
	}

}
