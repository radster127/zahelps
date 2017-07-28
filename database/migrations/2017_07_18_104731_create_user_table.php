<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
          $table->increments('id');

          $table->enum('user_type', ['admin', 'member']);

          $table->integer('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


          $table->string('username')->unique();
          $table->string('password');
          $table->string('ip_address', 20);

          $table->string('name');
          $table->string('email')->unique();
          $table->string('phone', 50);
          $table->string('avatar');

          $table->string('address');
          $table->string('city');
          $table->string('pincode', 20);
          $table->string('country');

          $table->string('bank_name');
          $table->string('bank_account_name');
          $table->string('bank_account_number');
          $table->string('bitcoin');

          $table->integer('referals');

          $table->datetime('joining_datetime');
          $table->datetime('last_login_datetime');
          $table->string('last_login_ip_address', 20);

          $table->enum('suspended', ['0', '1']);

          $table->string('facebook');
          $table->string('twitter');

          $table->float('account_balance');
          $table->float('admin_commision');
          $table->float('member_commision');
          $table->float('current_ph');

          $table->enum('status', ['active', 'inactive']);

          $table->rememberToken();

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
        Schema::drop('users');
    }
}
