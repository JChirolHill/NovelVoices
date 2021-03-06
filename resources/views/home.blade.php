@extends('layouts.full')

@section('title', 'Novel Voices | Home')
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

    #new-character-item:hover, .character-item-circle:hover {
      transform: rotate(90deg);
      cursor: pointer;
    }

    #new-character-item a {
      color: var(--primary-light);
    }
  </style>
@endsection

@section('content')
  @if(session('success'))
    <div class="alert alert-info">{{session('success')}}</div>
  @endif

  <div class="row">
    {{-- Characters Listing Section --}}
    <div class="col-12 col-md-8">
      <h3 class="mt-3 title-text">Your Characters</h3>
      {{-- List of characters for this user --}}
      <div class="d-flex character-list">
        <div class="character-item">
          <a href="/character">
            <div id="new-character-item" class="character-item-circle d-flex justify-content-center align-items-center">+</div>
          </a>
        </div>
        @forelse($characters as $character)
          <div class="character-item">
            <a href="/character/{{$character->id}}">
              <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, {{$character->color1}}, {{$character->color2}})"></div>
              <div class="text-center">{{$character->name}}</div>
            </a>
          </div>
        @empty
          <div class="d-flex align-items-center mx-3 font-italic">
            <h5>Give life to a character by pressing the button on the left or creating a new story below.</h5>
          </div>
        @endforelse
      </div>
    </div>

    {{-- Writer's Block Section --}}
    @if(sizeof($stories) > 0)
      <div class="col-12 col-md-4">
        <form class="text-center outline" action="/probe" method="get">
          <h3 class="title-text">Writer's Block?</h3>
          <div class="form-group">
            <label for="storySelect">Select your story:</label>
            <select id="storySelect" class="form-control" name="story">
              @foreach($stories as $story)
                <option value="{{$story->id}}">{{$story->title}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-my-primary" type="submit">Unblock Me</button>
          </div>
        </form>
      </div>
    @endif
  </div>

  <div class="row">
    <div class="col">
      <div class="mt-5 mb-5 mb-md-0">
        <div class="d-flex justify-content-between">
          <h3 class="title-text">Your Stories</h3>
          <a href="/story" class="btn btn-my-primary">Begin Your Story</a>
        </div>
        @forelse($stories as $index => $story)
          <a href="/story/{{$story->id}}">
            <div class="banner">
              @if($index % 2 == 0)
                <div class="pic">
                  <img src="{{ $story->theme->user_id ? $story->theme->url : asset("assets/{$story->theme->url}") }}" alt="{{$story->title}}"/>
                </div>
                <div class="banner-text-half">
                  <div class="coverup coverup-right"></div>
                  <div class="banner-text banner-text-right d-flex justify-content-center align-items-center">
                    <div class="ml-3 ml-md-0 mr-3 mr-md-5 text-right">
                      <h2 class="title-text">{{$story->title}}</h2>
                      <p>{{$story->descr}}</p>
                    </div>
                  </div>
                </div>
              @else
                <div class="banner-text-half">
                  <div class="coverup coverup-left"></div>
                  <div class="banner-text banner-text-left d-flex justify-content-center align-items-center">
                    <div class="ml-3 ml-md-5 mr-3 mr-md-0 text-left">
                      <h2 class="title-text">{{$story->title}}</h2>
                      <p>{{$story->descr}}</p>
                    </div>
                  </div>
                </div>
                <div class="pic">
                  <img src="{{ $story->theme->user_id ? $story->theme->url : asset("assets/{$story->theme->url}") }}" alt="{{$story->title}}"/>
                </div>
              @endif
            </div>
          </a>
        @empty
          <div class="font-italic text-center">
            <h5>You currently have no stories.  Create one to begin.</h5>
          </div>
        @endforelse
      </div>
    </div>
  </div>
@endsection
