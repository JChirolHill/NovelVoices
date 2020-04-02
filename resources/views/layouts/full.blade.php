@extends('layouts.main')

@section('mainContent')
  <div class="container">
    <div class="title-text my-4">
      <h1>@yield('header')</h1>
    </div>
    @yield('content')
  </div>
@endsection
