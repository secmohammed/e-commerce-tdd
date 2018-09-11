<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index();
            $table->integer('product_variation_type_id')->unsigned()->index();
            $table->text('details');
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->foreign('product_variation_type_id')->references('id')->on('product_variation_types');

            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variations', function($table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_variation_type_id']);
        });
        Schema::dropIfExists('product_variations');
    }
}
