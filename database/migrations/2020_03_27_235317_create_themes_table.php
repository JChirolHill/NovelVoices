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
            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('url');
        });

        // Insert initial values
        DB::table('themes')->insert([
            [
                'url' => 'beach.jpg',
                'user_id' => null
            ],
            [
                'url' => 'dream-catcher.jpg',
                'user_id' => null
            ],
            [
                'url' => 'friendship.jpg',
                'user_id' => null
            ],
            [
                'url' => 'ice.jpg',
                'user_id' => null
            ],
            [
                'url' => 'planet.jpg',
                'user_id' => null
            ],
            [
                'url' => 'sleeping.jpg',
                'user_id' => null
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
