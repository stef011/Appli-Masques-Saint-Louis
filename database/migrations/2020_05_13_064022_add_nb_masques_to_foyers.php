<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNbMasquesToFoyers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('foyers', function (Blueprint $table) {
            $table->unsignedInteger('nb_masques')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foyers', function (Blueprint $table) {
            $table->dropColumn('nb_masques');
        });
    }
}
