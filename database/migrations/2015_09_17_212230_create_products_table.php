<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dealer_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('sku');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('unit');
            $table->integer('list_price');
            $table->integer('quantity_on_hand');
            $table->decimal('selling_unit_factor', 5, 2);
            $table->integer('pricing_scalar');
            $table->timestamps();

            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
