<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
        });

        // Insert initial values
        DB::table('themes')->insert([
            [
                'url' => 'beach.jpg'
            ],
            [
                'url' => 'dream-catcher.jpg'
            ],
            [
                'url' => 'friendship.jpg'
            ],
            [
                'url' => 'ice.jpg'
            ],
            [
                'url' => 'planet.jpg'
            ],
            [
                'url' => 'sleeping.jpg'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
