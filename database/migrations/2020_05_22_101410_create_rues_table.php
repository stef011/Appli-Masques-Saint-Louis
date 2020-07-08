<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rues', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('quartier_id')->nullable();
            $table->timestamps();

            $table->foreign('quartier_id')
                ->references('id')->on('quartiers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rues');
    }
}
