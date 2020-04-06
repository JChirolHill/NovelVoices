<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Character;
use App\Story;

class HomeController extends Controller
{
    public function index() {
      // get all stories
      $stories = Story::with('theme')->where('user_id', '=', Auth::id())->get();

      // get all characters for those stories
      // ??? is there a better way to do this than in a for loop, some sort of sql advantage?
      $characters = [];

      return view('home', [
        'stories' => $stories,
        'characters' => $characters
      ]);
    }
}
