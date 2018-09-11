<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('carts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('product_variation_type_id')->unsigned();
			$table->integer('quantity')->default(1);
			$table->timestamps();
		});
		Schema::table('carts', function (Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->foreign('product_variation_type_id')->references('id')->on('product_variation_types')->onDelete('cascade');
		});
		Schema::create('user_cart', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('cart_id')->unsigned();
			$table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('carts', function (Blueprint $table) {
			$table->dropForeign(['product_id']);
		});
		Schema::table('user_cart', function (Blueprint $table) {
			$table->dropForeign(['user_id']);
			$table->dropForeign(['cart_id']);
		});
		Schema::dropIfExists('carts');
		Schema::dropIfExists('user_cart');
	}
}
