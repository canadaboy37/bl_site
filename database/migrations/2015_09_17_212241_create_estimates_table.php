<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dealer_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('notes')->nullable();
            $table->timestamp('last_refresh');
            $table->timestamps();

            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('estimates');
    }
}
