@extends('layouts.full')

@section('title', 'Home')
@section('header', 'Home')

@section('styles')
  <style media="screen">
    .outline {
      border-radius: 10px;
      border: 2px solid var(--ternary-dark);
      padding: 20px;
    }

    #new-character-item {
      background-image: linear-gradient(to bottom right, var(--ternary-dark), var(--secondary));
      font-size: 100px;
      color: var(--primary-light);
      transition: 0.5s all;
    }

    .character-list {
      overflow: scroll;
      width: 100%;
    }

    .character-list .character-item:not(:first-child) {
      margin: 0 10px;
    }

    #new-character-item:hover, .character-item-circle:hover {
      transform: rotate(90deg);
      cursor: pointer;
    }

    #new-character-item a {
      color: var(--primary-light);
    }

    .character-item {
      min-width: 100px;
    }

    .character-item-circle {
      height: 100px;
      border-radius: 50%;
      margin-bottom: 10px;
      transition: 0.5s all;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    {{-- Characters Listing Section --}}
    <div class="col-12 col-md-8">
      <div>
        <h3 class="mt-3 title-text">Your Characters</h3>
      {{-- List of characters for this user --}}
      <div class="d-flex character-list">
          <div class="character-item">
            <a href="/character">
            <div id="new-character-item" class="character-item-circle d-flex justify-content-center align-items-center">+</div>
          </div>
          </a>
      <div class="character-item">
            <a href="/character/1">
            <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, var(--primary), var(--secondary))"></div>
            <div class="text-center">Lia</div>
            </a>
          </div>
          <div class="character-item">
            <a href="/character/1">
              <div class="character-item-circle" style="background-image: linear-gradient(to bottom left, var(--secondary), var(--ternary))"></div>
              <div class="text-center">Aren</div>
            </a>
          </div>
          <div class="character-item">
            <a href="/character/1">
              <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, var(--primary-dark), var(--secondary))"></div>
              <div class="text-center">Evelyn</div>
            </a>
          </div>
          <div class="character-item">
            <a href="/character/1">
              <div class="character-item-circle" style="background-image: linear-gradient(to bottom left, var(--primary-light), var(--ternary))"></div>
              <div class="text-center">Rowan</div>
            </a>
          </div>
          <div class="character-item">
            <a href="/character/1">
              <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, var(--primary-dark), var(--ternary))"></div>
              <div class="text-center">Uber Really Long Name</div>
            </a>
          </div>
          <div class="character-item">
            <a href="/character/1">
              <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, var(--primary-dark), var(--ternary))"></div>
              <div class="text-center">Uber Really Long Name</div>
            </a>
          </div>
          <div class="character-item">
            <a href="/character/1">
              <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, var(--primary-dark), var(--ternary))"></div>
              <div class="text-center">Uber Really Long Name</div>
            </a>
          </div>
          <div class="character-item">
            <a href="/character/1">
              <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, var(--primary-dark), var(--ternary))"></div>
              <div class="text-center">Uber Really Long Name</div>
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- Writer's Block Section --}}
    <div class="col-12 col-md-4">
      <form class="text-center outline" action="index.html" method="post">
        <h3 class="title-text">Writer's Block?</h3>
        <div class="form-group">
          <label for="storySelect">Select your story:</label>
          <select id="storySelect" class="form-control">
            <option value="1">Story1</option>
            <option value="1">Story2</option>
            <option value="1">Story3</option>
            <option value="1">Story4</option>
          </select>
        </div>
        <div class="form-group">
          <button class="btn btn-my-primary" type="submit">Begin Chat</button>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="mt-5 mb-5 mb-md-0">
        <h3 class="title-text">Your Stories</h3>
        {{-- @foreach($banners as $index => $banner) --}}
          <a href="/story/1">
            <div class="banner">
              {{-- @if($index % 2 == 0) --}}
                <div class="pic">
                  <img src="{{ asset("assets/ice.jpg") }}" alt="ice"/>
                  {{-- <img src="{{ asset("assets/{$banner['image']}") }}" alt="{{$banner['title']}}"/> --}}
                </div>
                <div class="banner-text-half">
                  <div class="coverup coverup-right"></div>
                  <div class="banner-text banner-text-right d-flex justify-content-center align-items-center">
                    <div class="mr-5 text-right">
                      <h2 class="title-text">Story1</h2>
                      <p>My motivation for writing this story is to care about this dude who goes on a big hiking trip in the mountains and starts to learn the laws of nature along the way.</p>
                      {{-- <h2 class="title-text">{{$banner['title']}}</h2> --}}
                      {{-- <p>{{$banner['blurb']}}</p> --}}
                    </div>
                  </div>
                </div>
              </div> {{-- REMOVE! --}}
            </a>
            <a href="/story/1">
              <div class="banner"> {{-- REMOVE! --}}
              {{-- @else --}}
                <div class="banner-text-half">
                  <div class="coverup coverup-left"></div>
                  <div class="banner-text banner-text-left d-flex justify-content-center align-items-center">
                    <div class="ml-5 text-left">
                      <h2 class="title-text">Story2</h2>
                      <p>Just some weird stuff going on in the neighborhood.</p>
                      {{-- <h2 class="title-text">{{$banner['title']}}</h2> --}}
                      {{-- <p>{{$banner['blurb']}}</p> --}}
                    </div>
                  </div>
                </div>
                <div class="pic">
                  <img src="{{ asset("assets/friendship.jpg") }}" alt="friendship"/>
                  {{-- <img src="{{ asset("assets/{$banner['image']}") }}" alt="{{$banner['title']}}"/> --}}
                </div>
              {{-- @endif --}}
            </div>
          </a>
        {{-- @endforeach --}}
      </div>
    </div>
  </div>
@endsection
