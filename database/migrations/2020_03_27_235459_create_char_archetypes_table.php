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
        DB::table('hierarchies')->insert(
            array(
                'name' => 'Hero'
            ),
            array(
                'name' => 'Mentor'
            ),
            array(
                'name' => 'Everyman'
            ),
            array(
                'name' => 'Innocent'
            ),
            array(
                'name' => 'Villain/Shadow'
            ),
            array(
                'name' => 'Ally'
            ),
            array(
                'name' => 'Herald'
            ),
            array(
                'name' => 'Trickster'
            ),
            array(
                'name' => 'Shapshifter'
            ),
            array(
                'name' => 'Guardian'
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
        Schema::dropIfExists('char_archetypes');
    }
}
