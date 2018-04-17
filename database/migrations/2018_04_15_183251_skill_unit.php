<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SkillUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_unit', function (Blueprint $table) {
            $table->unsignedInteger('skill_id');
            $table->unsignedInteger('unit_id');
            $table->timestamps();
			
			$table->primary(['skill_id', 'unit_id']);
			
			$table->foreign('skill_id')->references('id')->on('skills');
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
        Schema::dropIfExists('skill_unit');
    }
}
