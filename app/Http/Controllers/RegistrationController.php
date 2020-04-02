<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;

class RegistrationController extends Controller
{
  public function show() {
    return view('authentication.signup');
  }

  public function register(Request $request) {
    try {
      $user = new User();
      $user->username = $request->input('username');
      $user->email = $request->input('email');
      $user->password = Hash::make($request->input('password'));
      $user->save();
    } catch(\Illuminate\Database\QueryException $e) {
      return redirect()->route('signup')
        ->with('error', 'It seems your email is already registered.  Try login instead.');
      // return redirect()->action('LoginController@alreadyMember', [
      //     'request' => $request,
      //     'error' => 'It seems we already have you registered.  Try logging in.'
      //   ]);
    }

    Auth::login($user);

    return redirect()->route('home');
  }
}
