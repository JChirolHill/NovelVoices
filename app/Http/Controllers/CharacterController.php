<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CharArchetype;
use App\Hierarchy;
use App\Character;
use Auth;

class CharacterController extends Controller
{
    public function index() {
      // get all archetypes
      $archetypes = CharArchetype::all();

      // get all hierarchies
      $hierarchies = Hierarchy::all();

      // hierarchy id associated with character extra
      $extraHierarchy = Hierarchy::where('name', '=', 'Extra')->first();

      return view('character.add', [
        'archetypes' => $archetypes,
        'hierarchies' => $hierarchies,
        'extraHierarchy' => $extraHierarchy
      ]);
    }

    public function store(Request $request) {
      dd($request);
      // validation
      $request->validate([
        'name' => 'required|max:50',
        'archetype' => 'required|exists:char_archetypes,id',
        'development' => 'required|integer|min:0|max:1',
        'hierarchy' => 'required|exists:hierarchies,id',
        'motivation' => 'required|min:5|max:120',
        'impression' => 'required|min:5|max:120',
        'backstory' => 'nullable|max:120',
        'strengths' => 'nullable',
        'weaknesses' => 'nullable'
      ]);

      // store in database
      $character = new Character();
      $character->name = $request->name;
      $character->user_id = Auth::id();
      $character->archetype_id = $request->archetype;
      $character->dynamic = $request->development;
      $character->hierarchy_id = $request->hierarchy;
      $character->motivation = $request->motivation;
      $character->impression = $request->impression;
      $character->backstory = $request->backstory;
      $character->strength = $request->strengths;
      $character->weakness = $request->weaknesses;
      $character->color1 = $this->random_color();
      $character->color2 = $this->random_color();
      $character->save();

      return redirect()
        ->route('home')
        ->with('success', "Successfully created character {$character->name}");
    }

    public function view(Character $character) {
      // parse out the strengths and weaknesses into arrays
      $strengths = $character->strength ? explode(";", $character->strength) : null;
      $weaknesses = $character->weakness ? explode(";", $character->weakness) : null;

      return view('character.view', [
        'character' => $character,
        'strengths' => $strengths,
        'weaknesses' => $weaknesses
      ]);
    }

    public function edit(Character $character) {
      // get all archetypes
      $archetypes = CharArchetype::all();

      // get all hierarchies
      $hierarchies = Hierarchy::all();

      // hierarchy id associated with character extra
      $extraHierarchy = Hierarchy::where('name', '=', 'Extra')->first();

      // parse out the strengths and weaknesses into arrays
      $strengths = $character->strength ? explode(";", $character->strength) : null;
      $weaknesses = $character->weakness ? explode(";", $character->weakness) : null;

      return view('character.add', [
        'character' => $character,
        'strengths' => $strengths,
        'weaknesses' => $weaknesses,
        'archetypes' => $archetypes,
        'hierarchies' => $hierarchies,
        'extraHierarchy' => $extraHierarchy
      ]);
    }

    public function update(Character $character, Request $request) {
      // validation
      $request->validate([
        'name' => 'required|max:50',
        'archetype' => 'required|exists:char_archetypes,id',
        'development' => 'required|integer|min:0|max:1',
        'hierarchy' => 'required|exists:hierarchies,id',
        'motivation' => 'required|min:5|max:120',
        'impression' => 'required|min:5|max:120',
        'backstory' => 'nullable|max:120',
        'strengths' => 'nullable',
        'weaknesses' => 'nullable'
      ]);

      // store in database
      $character->name = $request->name;
      $character->archetype_id = $request->archetype;
      $character->dynamic = $request->development;
      $character->hierarchy_id = $request->hierarchy;
      $character->motivation = $request->motivation;
      $character->impression = $request->impression;
      $character->backstory = $request->backstory;
      $character->strength = $request->strengths;
      $character->weakness = $request->weaknesses;
      $character->save();

      return redirect("/character/{$character->id}")
        ->with('success', "Successfully edited character {$character->name}");
    }

    public function delete(Character $character) {
      // remove this character from database
      $character->delete();

      // redirect to home with success message
      return redirect()
        ->route('home')
        ->with('success', "Successfully deleted character {$character->name}");
    }

    // generate random color (random hex code, then conver to color string)
    private function random_color_part() {
      return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    private function random_color() {
      return '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
}
