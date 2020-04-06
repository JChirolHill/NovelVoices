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

      // get all characters
      $characters = Character::where('user_id', '=', Auth::id())->get();

      return view('home', [
        'stories' => $stories,
        'characters' => $characters
      ]);
    }
}
