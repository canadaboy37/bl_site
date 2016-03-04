<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dealer_id')->unsigned();
            $table->integer('estimate_id')->unsigned();
            $table->integer('estimate_section_id')->unsigned()->nullable();
            $table->string('sku');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('unit');
            $table->integer('list_price');
            $table->integer('ext_price');
            $table->integer('quantity');
            $table->string('part_class');

            $table->timestamps();

            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
            $table->foreign('estimate_section_id')->references('id')->on('estimate_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('estimate_details');
    }
}
