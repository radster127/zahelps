<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
          $table->increments('id');

          $table->enum('message_type', ['message', 'pair_message']);

          $table->integer('from_id')->unsigned()->nullable();
          $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
          
          $table->integer('to_id')->unsigned()->nullable();
          $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');
          
          $table->integer('pair_id')->unsigned()->nullable();
          $table->foreign('pair_id')->references('id')->on('tb_pair')->onDelete('cascade');

          $table->string('subject');
          $table->text('message');
          $table->enum('is_read', ['0', '1']);
          $table->datetime('read_at');

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
        Schema::drop('messages');
    }
}
