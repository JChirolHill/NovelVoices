<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Parsedown;
use Exception;

class InfoController extends Controller
{
    public function index($topic) {
      // to be able to parse markdown into html
      // $Parsedown = new Parsedown();
      try {
        if(!file_exists("assets/{$topic}.txt")) {
          throw new Exception('File not found.');
        }
        $sourceFile = fopen("assets/{$topic}.txt", "r");

        $lines = [];
        while(!feof($sourceFile)) {
          // array_push($lines, $Parsedown->text(trim(fgets($myfile))));
          array_push($lines, trim(fgets($sourceFile)));
        }
        fclose($sourceFile);

        return view('info', [
          'lines' => $lines
        ]);
      } catch(Exception $e) {
        abort(404);
      }
    }
}
