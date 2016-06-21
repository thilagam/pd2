<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductConfigurationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cep_product_configurations', function(Blueprint $table)
		{
			$table->increments('pconf_id');
			$table->integer('pconf_product_id');
			$table->integer('pconf_item_id');
			$table->string('pconf_type',45)->nullable();
			$table->text('pconf_path')->nullable();
			$table->text('pconf_template')->nullable();
			$table->string('pconf_reference_id',2)->nullable();
			$table->timestamps();
			$table->double('pconf_created_by',20,0);
			$table->double('pconf_updated_by',20,0)->nullable();
			$table->tinyInteger('pconf_status')->default(1);
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cep_product_configurations');
	}

}
