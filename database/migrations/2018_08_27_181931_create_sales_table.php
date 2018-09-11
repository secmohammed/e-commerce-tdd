<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sales', function (Blueprint $table) {
			$table->increments('id');
			$table->float('percentage');
			$table->integer('saleable_id')->unsigned();
			$table->string('saleable_type');
			$table->boolean('active')->default(true);
			$table->integer('user_id')->unsigned();
			$table->timestamp('expires_at')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('sales');
	}
}
