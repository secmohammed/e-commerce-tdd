<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('products', function (Blueprint $table) {
			$table->increments('id');
			$table->string('photo')->nullable();
			$table->string('name')->unique();
			$table->text('description');
			$table->integer('price');
			$table->integer('user_id')->unsigned();
			// if (config('product.review')) {
			$table->boolean('reviewed')->default(false);
			$table->date('reviewed_at')->nullable();
			$table->integer('reviewed_by')->unsigned()->nullable();
			// }
			$table->timestamps();
		});
		Schema::table('products', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			// $table->foreign('product_category_id')->references('id')->on('categories')->onDelete('cascade');
			if (config('product.review')) {
				$table->foreign('reviewed_by')->references('id')->on('users')->onDelete('cascade');
			}
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('products', function (Blueprint $table) {
			$table->dropForeign(['user_id']);
			$table->dropForeign(['product_category_id']);
		});

		Schema::dropIfExists('products');

		Schema::dropIfExists('carts');
	}
}