<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index() {
      // values to populate content
      $banners = array(
        array(
          'title' => 'Dream',
          'image' => 'dream-catcher.jpg',
          'blurb' => 'Turn your dreams into stories worth sharing.'
        ),
        array(
          'title' => 'Share',
          'image' => 'sleeping.jpg',
          'blurb' => 'Create bedtime stories that your children will remember always.'
        ),
        array(
          'title' => 'Venture',
          'image' => 'friendship.jpg',
          'blurb' => 'Venture into the impossible.'
        ),
        array(
          'title' => 'Connect',
          'image' => 'beach.jpg',
          'blurb' => 'Craft lasting friendships between your characters and your audience.'
        ),
        array(
          'title' => 'Heal',
          'image' => 'man.jpg',
          'blurb' => 'Channel your pain to create authentic characters and meaningful stories.'
        ),
        array(
          'title' => 'Craft',
          'image' => 'planet.jpg',
          'blurb' => 'Introduce others to worlds of your making.'
        )
      );

      return view('landing', [
        'banners' => $banners
      ]);
    }
}
