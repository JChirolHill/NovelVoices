<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('dynamic');
            $table->integer('hierarchy_id');
            $table->integer('archetype_id');
            $table->foreign('hierarchy_id')->references('id')->on('hierarchies');
            $table->foreign('archetype_id')->references('id')->on('char_archetypes')->nullable();
            $table->string('motivation')->nullable();
            $table->string('impression')->nullable();
            $table->string('backstory')->nullable();
            $table->string('strength')->nullable();
            $table->string('weakness')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
