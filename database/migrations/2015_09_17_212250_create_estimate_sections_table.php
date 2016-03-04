<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dealer_id')->unsigned();
            $table->integer('estimate_id')->unsigned();
            $table->string('name');
            $table->timestamp('last_refresh');
            $table->timestamps();

            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('estimate_sections');
    }
}
