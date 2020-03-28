<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryArchetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story_archetypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        // Insert initial values
        DB::table('hierarchies')->insert(
            array(
                'name' => 'Overcoming the Monster'
            ),
            array(
                'name' => 'Rags to Riches'
            ),
            array(
                'name' => 'The Quest'
            ),
            array(
                'name' => 'Voyage and Return'
            ),
            array(
                'name' => 'Comedy'
            ),
            array(
                'name' => 'Tragedy'
            ),
            array(
                'name' => 'Rebirth'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('story_archetypes');
    }
}
