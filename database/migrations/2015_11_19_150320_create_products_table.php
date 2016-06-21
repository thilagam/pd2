<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cep_products', function(Blueprint $table)
		{
			$table->increments('prod_id');
			$table->string('prod_name',100)->unique();
			$table->double('prod_created_by', 20, 0);
			$table->double('prod_updated_by', 20, 0)->nullable();
			$table->timestamps();
			$table->tinyInteger('prod_status')->default(1);
			
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cep_products');
	}

}
