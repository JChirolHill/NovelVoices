@extends('layouts.full')

@section('title', 'Novel Voices | View Story')
@section('header', $story->title)

@section('styles')
  <style media="screen">
    body {
      background-image: url({{ asset("assets/{$story->theme->url}") }});
      background-repeat: no-repeat;
      background-size: cover;
    }

    .container {
      border-radius: 10px;
      background-color: rgba(252, 255, 253, 0.7);
    }

    .list-group-item {
      background: none;
    }

    .list-group-item h4 i {
      opacity: 0;
      transition: all 0.25s;
      color: var(--secondary-dark);
    }

    .list-group-item h4 i:hover {
      cursor: pointer;
    }

    .list-group-item h4:hover i {
      opacity: 1;
    }

    .character-item-circle:hover {
      transform: rotate(90deg);
      cursor: pointer;
    }
  </style>
@endsection

@section('content')
  @if(session('success'))
    <div class="alert alert-info">{{session('success')}}</div>
  @endif
  
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <h4>What Makes this Story Worth Telling <a href="/story/{{$story->id}}/edit"><i class="fas fa-edit"></i></a></h4>
      <p>{{$story->descr}}</p>
    </li>
    <li class="list-group-item">
      <h4>Story Archetype: {{$story->archetype->name}} <a href="/story/{{$story->id}}/edit"><i class="fas fa-edit"></i></a></h4>
      Read more about <a href="/info/story_archetypes" target="_blank">story archetypes.</a>
    </li>
    <li class="list-group-item">
      <h4>Characters in this Story <a href="/story/{{$story->id}}/edit"><i class="fas fa-edit"></i></a></h4>
      <div class="d-flex character-list">
        @forelse($characters as $character)
          <div class="character-item">
            <a href="/character/{{$character->id}}">
              <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, {{$character->color1}}, {{$character->color2}})"></div>
              <div class="text-center">{{$character->name}}</div>
            </a>
          </div>
        @empty
          <div class="d-flex align-items-center mx-3 font-italic">
            <h5>You currently have no characters for this story.</h5>
          </div>
        @endforelse
      </div>
    </li>
  </ul>
@endsection
