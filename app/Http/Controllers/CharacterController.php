<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CharArchetype;
use App\Hierarchy;

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
      // dd($request);

      // validation
      $request->validate([
        'name' => 'required|max:50',
        'archetype' => 'required|exists:char_archetypes,id',
        'development' => 'required|integer|min:0|max:1',
        'hierarchy' => 'required|exists:hierarchies,id',
        'motivation' => 'required|min:5|max:120',
        'impression' => 'required|min:5|max:120',
        'backstory' => 'nullable|max:120'
      ]);

    }
}
