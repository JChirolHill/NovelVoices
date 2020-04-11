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
          [ 'name' => 'Hero' ],
          [ 'name' => 'Mentor' ],
          [ 'name' => 'Everyman' ],
          [ 'name' => 'Innocent' ],
          [ 'name' => 'Villain/Shadow' ],
          [ 'name' => 'Ally' ],
          [ 'name' => 'Herald' ],
          [ 'name' => 'Trickster' ],
          [ 'name' => 'Shapshifter' ],
          [ 'name' => 'Guardian' ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('char_archetypes');
    }
}
