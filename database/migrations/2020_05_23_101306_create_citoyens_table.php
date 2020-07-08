<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitoyensTable extends Migration
{
    /** 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citoyens', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_de_naissance');
            $table->boolean('prioritaire')->default(false);
            $table->date('date_de_demande')->nullable();
            $table->unsignedBigInteger('foyer_id');
            $table->timestamps();

            $table->foreign('foyer_id')
                ->references('id')
                ->on('foyers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citoyens');
    }
}
