<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhProfitHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ph_profit_history', function (Blueprint $table) {
          $table->increments('id');
          
          $table->integer('ph_id')->unsigned()->nullable();
          $table->foreign('ph_id')->references('id')->on('tb_ph')->onDelete('cascade');
          
          $table->integer('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          
          $table->integer('level_number')->default('0');
          
          $table->float('profit_percentage')->default('0');
          $table->float('profit_amount')->default('0');
          
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ph_profit_history');
    }
}
