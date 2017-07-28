<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pair', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('ph_id')->unsigned()->nullable();
          $table->foreign('ph_id')->references('id')->on('tb_ph')->onDelete('cascade');
          $table->integer('gh_id')->unsigned()->nullable();
          $table->foreign('gh_id')->references('id')->on('tb_gh')->onDelete('cascade');

          $table->datetime('expired_on');
          $table->datetime('auto_approved_on');
          $table->datetime('approved_on');
          $table->string('reason');

          $table->enum('status', ['paired', 'approved', 'expired']);
          $table->enum('payment_type', ['pending', 'bank', 'bitcoin']);

          $table->float('amount');

          $table->string('token', 25);
          $table->string('proof_picture');

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
        Schema::drop('tb_pair');
    }
}
