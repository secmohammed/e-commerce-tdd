<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_attribute_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('product_category_id')->unsigned();
            $table->text('values');
            $table->timestamps();
        });
        Schema::table('category_attribute_values', function (Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_attribute_values', function (Blueprint $table){
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_category_id']);
        });

        Schema::dropIfExists('category_attribute_values');
    }
}
