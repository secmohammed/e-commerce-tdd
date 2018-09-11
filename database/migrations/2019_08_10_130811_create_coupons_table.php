<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('coupons', function (Blueprint $table) {
			$table->increments('id');
			$table->string('code', 32);
			$table->integer('user_id')->unsigned();
			$table->integer('amount')->default(1);
			$table->boolean('active')->default(true);
			$table->timestamp('expires_at')->nullable();
			$table->float('percentage')->default(0);
			$table->timestamps();
		});
		Schema::table('coupons', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
		Schema::create('user_coupon', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('coupon_id')->unsigned();
			$table->boolean('purchased')->default(false);
			$table->primary(['user_id', 'coupon_id']);
		});
		Schema::table('user_coupon', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('coupons', function (Blueprint $table) {
			$table->dropForeign(['user_id']);
		});
		Schema::table('user_coupon', function (Blueprint $table) {
			$table->dropForeign(['user_id']);
			$table->dropForeign(['coupon_id']);
		});
		Schema::dropIfExists('user_coupon');
		Schema::dropIfExists('coupons');
	}
}
