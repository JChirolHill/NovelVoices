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
        $response['message0'] = "Tell me more about the relevance of the following in your story: {$clickableMatches[0]}";
        $response['message1'] = "In what ways could it impact your characters?";
        $response['message2'] = "How else could it be important? ";
      }
      else if($characterFound) {
        // a character is mentioned in the message
        $response['todo'] = 'post';
        $response['message0'] = "What's so important about {$characterMatches[0]}?";
        $response['message1'] = "Why else could {$characterMatches[0]} be important in overall the story?";
        $response['message2'] = "Give one more reason {$characterMatches[0]} matters for your story.";
      }
      else {
        $response['todo'] = 'entityAnalysis';
        $response['original'] = $request->input('message');
        // $response['message'] = "I'm not sure what you're saying.";
      }

      return response()->json($response);
    }

    public function handleEntities(Request $request) {
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

      $response = [];
      if($location) {
        // response if found location entity
        $response['todo'] = 'post';
        $response['message0'] = "What else could happen in this place: {$location}";
        $response['message1'] = "What significance could this place have for your characters?";
        $response['message2'] = "How could the relevance of this place be the same or different for individual characters?";
      }
      else if($event) {
        // response if found location entity
        $response['todo'] = 'post';
        $response['message0'] = "What else could happen during this event: {$event}";
        $response['message1'] = "To what extend does this event impact your characters?";
        $response['message2'] = "How does this event change the course of the story or move it forward?";
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
