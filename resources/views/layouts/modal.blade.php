@extends('layouts.main')

@section('mainContent')
  <div class="container">
    <div class="col-12 col-md-6 mx-auto">
      <div class="text-center title-text my-4">
        <h1>@yield('header')</h1>
      </div>
      @yield('content')
    </div>
  </div>
@endsection
