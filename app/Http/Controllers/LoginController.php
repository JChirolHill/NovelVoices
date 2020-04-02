<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class LoginController extends Controller
{
  public function show() {
    // dd(DB::table('users')->get());
    return view('authentication.login');
  }

  // called when user tries to signup but already has account, redirected to login
  // public function alreadyMember(Request $request, $error) {
  //   dd($error);
  //     return view('authentication.login', [
  //       'email' => $request->input('email'),
  //       'password' => $request->input('password')
  //     ])->with('error', $error);
  // }

  public function login(Request $request) {
    $isLoginSuccessful = Auth::attempt([
      'email' => $request->input('email'),
      'password' => $request->input('password')
    ]);

    if($isLoginSuccessful) {
      return redirect()->route('home');
    }
    else {
      return redirect()->route('login')->with('error', 'Unable to login.  Check your credentials.');
    }
  }
}
