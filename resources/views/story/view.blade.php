@extends('layouts.full')

@section('title', 'Novel Voices | View Story')
@section('header', $story->title)

@section('styles')
  <style media="screen">
    body {
      background-image: url({{ $story->theme->user_id ? $story->theme->url : asset("assets/{$story->theme->url}") }});
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

  <div class="text-right">
    <button class="btn text-danger" type="button" data-toggle="modal" data-target="#deleteModal">Delete</button>
  </div>

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

  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete {{$story->title}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-danger">
          Are you sure you want to delete {{$story->title}}?  This action cannot be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a href="/story/{{$story->id}}/delete" class="btn btn-danger">Delete</a>
        </div>
      </div>
    </div>
  </div>
@endsection
