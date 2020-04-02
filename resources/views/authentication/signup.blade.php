@extends('layouts.modal')

@section('title', 'Sign Up')
@section('header', 'Sign Up')

@section('content')
  @if(session('error'))
    <div class="text-danger text-center">
      {{session('error')}}
    </div>
  @endif
  <form method="post" action="/signup">
    @csrf
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text"name="username" class="form-control">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control">
    </div>
    <div class="form-group text-right">
      <input type="submit" value="Sign Up" class="btn btn-my-primary">
    </div>
  </form>
  <div class="text-center">
    <p>Already have an account? Please <a href="/login">login</a>.</p>
  </div>
@endsection
