<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryIdInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          //

          if (Schema::hasColumn('users', 'country')) { //check whether users table has country column
            $table->dropColumn('country');
          }

          $table->integer('country_id')->unsigned()->nullable()->after('pincode');
          $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
          //
          if (Schema::hasColumn('users', 'country')) {
            $table->dropForeign(['country_id']);
            $table->dropColumn(['country_id']);
          }
        });
    }
}
