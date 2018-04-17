<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrewUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_unit', function (Blueprint $table) {
            $table->unsignedInteger('crew_id');
            $table->unsignedInteger('unit_id');
            $table->timestamps();
			
			$table->primary(['crew_id', 'unit_id']);
			
			$table->foreign('crew_id')->references('id')->on('crews');
			$table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crew_unit');
    }
}
