<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHierarchiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hierarchies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        // Insert initial values
        DB::table('hierarchies')->insert(
            array(
                'name' => 'Major Character'
            ),
            array(
                'name' => 'Minor Character'
            ),
            array(
                'name' => 'Extra'
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
        Schema::dropIfExists('hierarchies');
    }
}
