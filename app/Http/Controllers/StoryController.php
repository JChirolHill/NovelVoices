<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Story;
use App\StoryArchetype;
use App\Character;
use App\Theme;

class StoryController extends Controller
{
    public function index() {
      // get all characters for this user
      $characters = Character::with('archetype')->where('user_id', '=', Auth::id())->get();

      // get all themes
      $themes = Theme::all();

      // get all archetypes
      $archetypes = StoryArchetype::all();

      return view('story.add', [
        'characters' => $characters,
        'themes' => $themes,
        'archetypes' => $archetypes
      ]);
    }

    public function store(Request $request) {
      // validation
      $request->validate([
        'title' => ['required', 'max:50',
          Rule::unique('stories')->where(function ($query) {
            return $query->where('user_id', Auth::id());
          })
        ],
        'descr' => 'required',
        'archetype' => 'required|exists:story_archetypes,id',
        'theme' => 'exists:themes,id',
        'characters.*' => 'exists:characters,id'
      ]);

      // store in database
      $story = new Story();
      $story->title = $request->title;
      $story->user_id = Auth::id();
      $story->theme_id = $request->theme;
      $story->archetype_id = $request->archetype;
      $story->descr = $request->descr;
      $story->save();

      $this->updateManyToManyChars($story, $request->characters);

      // redirect to home with success
      return redirect()
        ->route('home')
        ->with('success', "Successfully created story {$story->title}");
    }

    public function view(Story $story) {
      return view('story.view', [
        'story' => $story,
        'characters' => $story->characters
      ]);
    }

    public function edit(Story $story) {
      // get all characters for this user
      $characters = Character::with('archetype')->where('user_id', '=', Auth::id())->get();

      // get all themes
      $themes = Theme::all();

      // get all archetypes
      $archetypes = StoryArchetype::all();

      return view('story.add', [
        'story' => $story,
        'characters' => $characters,
        'themes' => $themes,
        'archetypes' => $archetypes
      ]);
    }

    public function update(Story $story, Request $request) {
      // validation
      $request->validate([
        'title' => ['required', 'max:50',
          Rule::unique('stories')->where(function ($query) {
            return $query->where('user_id', Auth::id());
          })->ignore($story->id)
        ],
        'descr' => 'required',
        'archetype' => 'required|exists:story_archetypes,id',
        'theme' => 'exists:themes,id',
        'characters.*' => 'exists:characters,id'
      ]);

      // store in database
      $story->title = $request->title;
      $story->theme_id = $request->theme;
      $story->archetype_id = $request->archetype;
      $story->descr = $request->descr;
      $story->save();

      $this->updateManyToManyChars($story, $request->characters);

      // redirect to home with success
      return redirect("/story/{$story->id}")
        ->with('success', "Successfully edited story {$story->title}");
    }

    public function delete(Story $story) {
      // remove this story from database
      $story->delete();

      // redirect to home with success message
      return redirect()
        ->route('home')
        ->with('success', "Successfully deleted story {$story->title}");
    }

    public function archetypes() {
      $archetypes = StoryArchetype::all();
      return response()->json($archetypes);
    }

    public function updateManyToManyChars($story, $newCharIds) {
      // clear many to many relationships for characters
      foreach($story->characters as $character) {
        $story->characters()->detach(Character::find($character->id));
      }

      // add many to many relationships for characters
      foreach($newCharIds as $charId) {
        $story->characters()->attach(Character::find($charId));
      }
    }
}
