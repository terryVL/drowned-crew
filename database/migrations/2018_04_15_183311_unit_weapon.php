<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UnitWeapon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_weapon', function (Blueprint $table) {
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('weapon_id');
            $table->timestamps();
			
			$table->primary(['unit_id', 'weapon_id']);
			
			$table->foreign('unit_id')->references('id')->on('units');
			$table->foreign('weapon_id')->references('id')->on('weapons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_weapon');
    }
}
