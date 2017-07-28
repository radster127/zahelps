<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
          $table->increments('id');

          $table->string('setting_type');
          $table->string('name');
          $table->string('value');
          $table->mediumText('title');
          $table->mediumText('help_text');
          $table->string('field_type');
          $table->mediumText('field_options');

          $table->integer('min_value')->nullable();
          $table->integer('max_value')->nullable();
          $table->integer('min_length')->nullable();
          $table->integer('max_length')->nullable();

          $table->enum('required', ['0', '1']);

          $table->integer('setting_order')->nullable();
          
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
        Schema::drop('settings');
    }
}
