<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharArchetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('char_archetypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        // Insert initial values
        DB::table('char_archetypes')->insert([
          [ 'name' => 'The Hero' ],
          [ 'name' => 'The Mentor' ],
          [ 'name' => 'The Everyman' ],
          [ 'name' => 'The Innocent' ],
          [ 'name' => 'The Shadow' ],
          [ 'name' => 'The Ally' ],
          [ 'name' => 'The Herald' ],
          [ 'name' => 'The Trickster' ],
          [ 'name' => 'The Shapshifter' ],
          [ 'name' => 'The Guardian' ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // TODO: remove this line
        Schema::dropIfExists('characters'); // so able to drop everything, else get foreign key constraint

        Schema::dropIfExists('char_archetypes');
    }
}
