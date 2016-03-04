<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dealer_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->string('username');
            $table->string('password', 60);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->boolean('is_salesperson');
            $table->timestamp('last_statement_sent')->nullable;
            $table->timestamp('last_invoice_sent')->nullable;
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
