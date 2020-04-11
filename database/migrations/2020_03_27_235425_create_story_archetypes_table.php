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
        DB::table('story_archetypes')->insert([
            [ 'name' => 'Overcoming the Monster' ],
            [ 'name' => 'Rags to Riches' ],
            [ 'name' => 'The Quest' ],
            [ 'name' => 'Voyage and Return' ],
            [ 'name' => 'Comedy' ],
            [ 'name' => 'Tragedy' ],
            [ 'name' => 'Rebirth' ]
          ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // TODO: remove this line
        Schema::dropIfExists('stories'); // so able to drop everything, else get foreign key constraint

        Schema::dropIfExists('story_archetypes');
    }
}
