<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foyers', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->unsignedBigInteger('id_rue');


            $table->foreign('id_rue')
                ->references('id')
                ->on('rues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foyers');
    }
}
