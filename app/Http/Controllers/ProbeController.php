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
        $response['messages'] = [
          "Tell me more about the relevance of the following in your story: {$clickableMatches[0]}",
          "In what ways could it impact your characters?",
          "How else could it be important? "
        ];
      }
      else if($characterFound) {
        // a character is mentioned in the message
        $response['todo'] = 'post';
        $response['messages'] = [
          "What's so important about {$characterMatches[0]}?",
          "Why else could {$characterMatches[0]} be important in overall the story?",
          "Give one more reason {$characterMatches[0]} matters for your story."
        ];
      }
      else {
        $response['todo'] = 'entityAnalysis';
        $response['original'] = $request->input('message');
      }

      return response()->json($response);
    }

    public function handleEntities(Request $request) {
      $response = [];

      if(sizeof($request->input('entities')) === 0) {
        // no entities detected, prompt user with simple message
        $response['todo'] = 'new_prompt';
        $response['message'] = 'Anything else you want to delve deeper into?  Tell me what else is blocking you or select a character from the left to continue.';
      }
      else {
        // see if location mentioned
        $location = "";
        $event = "";
        foreach($request->input('entities') as $entity) {
          if($entity['type'] == 'LOCATION') {
            $location = $entity['name'];
            break;
          }
          else if($entity['type'] == 'EVENT') {
            $event = $entity['name'];
            break;
          }
        }

        if($location) {
          // response if found location entity
          $response['todo'] = 'post';
          $response['messages'] = [
            "What else could happen in this place: {$location}",
            "What significance could this place have for your characters?",
            "How could the relevance of this place be the same or different for individual characters?"
          ];
        }
        else if($event) {
          // response if found location entity
          $response['todo'] = 'post';
          $response['messages'] = [
            "What else could happen during this event: {$event}",
            "To what extend does this event impact your characters?",
            "How does this event change the course of the story or move it forward?"
          ];
        }
        else {
          // send back all entities
          $response['todo'] = 'clickables';
          $response['entities'] = $request->input('entities');
          $response['message'] = "Please pick one of the following to delve deeper into:";
        }
      }

      return response()->json($response);
    }
}
