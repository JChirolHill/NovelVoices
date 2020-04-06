<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    public function user() {
      return $this->belongsTo('App\User');
    }

    public function characters() {
      return $this->belongsToMany('App\Character', 'story_character');
    }

    public function archetype() {
      return $this->belongsTo('App\StoryArchetype');
    }

    public function theme() {
      return $this->belongsTo('App\Theme');
    }
}
