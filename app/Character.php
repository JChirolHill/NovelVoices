<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public function archetype() {
      return $this->belongsTo('App\CharArchetype');
    }

    public function hierarchy() {
      return $this->belongsTo('App\Hierarchy');
    }

    public function stories() {
      return $this->belongsToMany('App\Story', 'story_character');
    }
}
