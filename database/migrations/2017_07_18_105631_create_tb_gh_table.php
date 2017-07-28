<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbGhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_gh', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

          $table->string('transaction_code', 20);
          $table->text('user_information');

          $table->float('amount');
          $table->float('pending_amount');

          $table->datetime('lock_gh');

          $table->string('ip_address', 20);
          $table->enum('status', ['pending', 'paired', 'approved', 'rejected', 'frozen', 'completed']);

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
        Schema::drop('tb_gh');
    }
}
