<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\StoryArchetype;
use App\Character;

class StoryController extends Controller
{
    public function index() {
      // get all characters for this user
      $characters = Character::with('archetype')->where('user_id', '=', Auth::id())->get();

      return view('story.add', [
        'characters' => $characters
      ]);
    }

    public function store() {

    }

    public function archetypes() {
      $archetypes = StoryArchetype::all();
      return response()->json($archetypes);
    }
}
