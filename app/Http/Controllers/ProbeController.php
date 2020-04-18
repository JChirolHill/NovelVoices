<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;

class ProbeController extends Controller
{
    public function index(Request $request) {
      $story = Story::find($request->input('story'));

      // validate that story id is valid
      if(!$story) {
        abort(404);
      }

      return view('probe', [
        'story' => $story
      ]);
    }

    public function handleMessage(Request $request) {
      $response = [];
      $characterMatches = [];
      $clickableMatches = [];

      // parse to have an idea what kind of message is
      $characterFound = preg_match('/(?<=@)\w*/', $request->input('message'), $characterMatches);
      $clickableFound = preg_match('/(?<=#)\w*/', $request->input('message'), $clickableMatches);
      if($clickableMatches) {
        // a clickable item was mentioned in the message
        $response['todo'] = 'post';
        $response['message'] = "Tell me more about the relevance of the following in your story: {$clickableMatches[0]}";
      }
      else if($characterFound) {
        // a character is mentioned in the message
        $response['todo'] = 'post';
        $response['message'] = "What's so important about {$characterMatches[0]}?";
      }
      else {
        $response['todo'] = 'entityAnalysis';
        $response['original'] = $request->input('message');
        $response['message'] = "I'm not sure what you're saying.";
      }

      return response()->json($response);
    }

    public function handleEntities(Request $request) {
      // see if location mentioned
      $location = "";
      foreach($request->input('entities') as $entity) {
        if($entity['type'] == 'LOCATION') {
          $location = $entity['name'];
          break;
        }
      }

      $response = [];
      if($location) {
        // response if found location entity
        $response['todo'] = 'post';
        $response['message'] = "What else could happen in this place: {$location}";
      }
      else {
        // send back all entities
        $response['todo'] = 'clickables';
        $response['entities'] = $request->input('entities');
        $response['message'] = "Please pick one of the following to delve deeper into:";
      }
      
      return response()->json($response);
    }
}
