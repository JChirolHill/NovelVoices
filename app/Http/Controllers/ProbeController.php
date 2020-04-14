<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProbeController extends Controller
{
    public function index() {
      // validate that story id is valid

      return view('probe');
    }
}
