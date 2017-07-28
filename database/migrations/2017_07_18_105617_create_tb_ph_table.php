<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ph', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

          $table->string('transaction_code', 20);

          $table->float('profit_per_day_percentage'); // per day profit percentages
          $table->integer('profit_total_days'); // number of total days to get profit
          $table->integer('profit_day_counter'); // number of days of profit got

          $table->text('user_information');

          $table->float('amount'); 
          $table->float('pending_amount'); 

          $table->datetime('lock_ph');

          $table->float('admin_commission_percentage');
          $table->float('admin_commission');

          $table->float('ph_capital');
          $table->float('ph_profit');
          $table->datetime('profit_start_datetime');
          $table->enum('profit_credited', ['0', '1']);
          $table->datetime('profit_credited_datetime');

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
        Schema::drop('tb_ph');
    }
}
