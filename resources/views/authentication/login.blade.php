@extends('layouts.modal')

@section('title', 'Login')
@section('header', 'Login')

@section('content')
  @if(session('error'))
    <div class="text-danger text-center">
      {{session('error')}}
    </div>
  @endif
  <form method="post" action="/login">
    @csrf
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group text-right">
      <input type="submit" value="Login" class="btn btn-my-primary">
    </div>
  </form>
  <div class="text-center">
    <p>Don't have an account? Please <a href="/signup">sign up</a>.</p>
  </div>
@endsection
