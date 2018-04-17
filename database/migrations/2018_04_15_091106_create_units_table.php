<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('faction_id');
            $table->text('name');
            $table->text('unique_name');
            $table->integer('type');
            $table->unsignedInteger('role_id')->nullable();
            $table->integer('max');
            $table->integer('points');
            $table->integer('action_points');
            $table->integer('action_points_max');
            $table->integer('pass_speed');
            $table->integer('nail_speed');
            $table->integer('wounds');
            $table->integer('armor');
            $table->integer('close_combat');
            $table->integer('agility');
            $table->integer('marksmanship');
            $table->integer('intelligence');
            $table->integer('toughness');
            $table->timestamps();
			
			$table->foreign('faction_id')->references('id')->on('factions');
			$table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
