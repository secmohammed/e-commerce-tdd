<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('wishlists', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('product_variation_type_id')->unsigned();
			$table->integer('quantity')->default(1);
			$table->timestamps();
		});
		Schema::table('wishlists', function (Blueprint $table) {
			$table->foreign('product_variation_type_id')->references('id')->on('product_variation_types')->onDelete('cascade');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
		});
		Schema::create('user_wishlist', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('wishlist_id')->unsigned();
			$table->foreign('wishlist_id')->references('id')->on('wishlists')->onDelete('cascade');

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('wishlists', function (Blueprint $table) {
			$table->dropForeign(['product_id']);
			$table->dropForeign(['product_variation_type_id']);
		});
		Schema::table('user_wishlist', function (Blueprint $table) {
			$table->dropForeign(['user_id']);
			$table->dropForeign(['wishlist_id']);
		});
		Schema::dropIfExists('wishlists');
		Schema::dropIfExists('user_wishlist');
	}
}
