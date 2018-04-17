<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SpecialWeapon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_weapon', function (Blueprint $table) {
            $table->unsignedInteger('special_id');
            $table->unsignedInteger('weapon_id');
            $table->timestamps();
			
			$table->primary(['special_id', 'weapon_id']);
			
			$table->foreign('special_id')->references('id')->on('specials');
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
        Schema::dropIfExists('special_weapon');
    }
}
