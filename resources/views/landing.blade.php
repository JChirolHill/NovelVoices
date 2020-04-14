@extends('layouts.main')
@section('title', 'Novel Voices')

@section('styles')
  <style media="screen">
    /* make navbar stick to top */
    .navbar {
      position: fixed;
      width: 100%;
      z-index: 3;
    }

    .hero {
      background-image: url({{ asset('assets/ice.jpg') }});
      height: 500px;
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      color: white;
      text-shadow: 2px 2px 8px var(--primary-dark);
    }

    .hero div {
      width: 80%;
      margin: 0 auto;
    }

    .hero h1 {
      margin-bottom: -20px;
      transition: all 0.75s;
      font-size: 50px;
      opacity: 0;
    }

    .hero h3 {
      padding-top: 1rem;
      border-top: var(--primary-light) solid 2px;
    }

    @media (min-width: 768px) {
      .hero div {
        width: 60%;
      }
    }
  </style>
@endsection

@section('mainContent')
  <div class="hero d-flex align-items-center text-center">
    <div>
      <h1 class="title-text">Novel Voices</h1>
      <h3>Character-driven story development<br />to bring your characters to life</h3>
    </div>
  </div>

  @foreach($banners as $index => $banner)
    <div class="banner">
      @if($index % 2 == 0)
        <div class="pic">
          <img src="{{ asset("assets/{$banner['image']}") }}" alt="{{$banner['title']}}"/>
        </div>
        <div class="banner-text-half">
          <div class="coverup coverup-right"></div>
          <div class="banner-text banner-text-right d-flex justify-content-center align-items-center">
            <div class="ml-5 ml-md-0 mr-5 text-center text-md-right">
              <h2 class="title-text">{{$banner['title']}}</h2>
              <p>{{$banner['blurb']}}</p>
            </div>
          </div>
        </div>
      @else
        <div class="banner-text-half">
          <div class="coverup coverup-left"></div>
          <div class="banner-text banner-text-left d-flex justify-content-center align-items-center">
            <div class="ml-5 mr-5 mr-md-0 text-center text-md-left">
              <h2 class="title-text">{{$banner['title']}}</h2>
              <p>{{$banner['blurb']}}</p>
            </div>
          </div>
        </div>
        <div class="pic">
          <img src="{{ asset("assets/{$banner['image']}") }}" alt="{{$banner['title']}}"/>
        </div>
      @endif
    </div>
  @endforeach
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(() => {
      // fade in title
      // $('.hero h1').fadeIn(1000);
      $('.hero h1').css('opacity', '1');
      $('.hero h1').css('margin-bottom', '10px');
    });
  </script>
@endsection
