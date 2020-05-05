<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuartiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quartiers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->integer('distribue')->default(0);
            $table->integer('stock')->default(0);
        });

        //quartier_user
        Schema::create('quartier_user', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('quartier_id');
        $table->unsignedBigInteger('user_id');

        $table->unique(['quartier_id', 'user_id']);

        $table->foreign('quartier_id')
            ->references('id')
            ->on('quartiers');

        $table->foreign('user_id')
            ->references('id')
            ->on('users');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quartiers');
    }
}
