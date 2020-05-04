@extends('layouts.full')

@section('title', "Novel Voices | $character->name")
@section('header', "Meet $character->name")

@section('styles')
  <style media="screen">
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
  </style>
@endsection

@section('content')
  <div class="text-right">
    <button class="btn text-danger" type="button" data-toggle="modal" data-target="#deleteModal">Delete</button>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <h4>My Character Archetype: {{$character->archetype->name}} <a href="/character/{{$character->id}}/edit"><i class="fas fa-edit"></i></a></h4>
      Read more about <a href="/info/character_archetypes" target="_blank">character archetypes.</a>
    </li>
    <li class="list-group-item">
      <h4>I am a {{$character->dynamic ? 'Dynamic' : 'Static'}} character <a href="/character/{{$character->id}}/edit"><i class="fas fa-edit"></i></a></h4>
      Read more about types of <a href="/info/dynamic_static" target="_blank">character development</a>.
    </li>
    <li class="list-group-item">
      <h4>I am a {{$character->hierarchy->name}} character <a href="/character/{{$character->id}}/edit"><i class="fas fa-edit"></i></a></h4>
      Read more about <a href="/info/hierarchies" target="_blank">character hierarchies</a>.
    </li>
    <li class="list-group-item">
      <h4>I Appear In</h4>
      @if(sizeof($character->stories) > 0)
        <div class="row">
          @foreach($character->stories as $story)
            <div class="col-2"><a href="/story/{{$story->id}}">{{$story->title}}</a></div>
          @endforeach
        </div>
      @else
        I do not yet appear in any stories.
      @endif
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="card col-12 col-md mx-2 mb-2 mb-md-0">
          <div class="card-body">
            <h4 class="card-title">Motivation <a href="/character/{{$character->id}}/edit"><i class="fas fa-edit"></i></a></h4>
            <h6 class="card-subtitle mb-2 text-muted">What I want and what drives me</h6>
            <p class="card-text">{{$character->motivation}}</p>
          </div>
        </div>
        <div class="card col-12 col-md mx-2 mb-2 mb-md-0">
          <div class="card-body">
            <h4 class="card-title">First Impression <a href="/character/{{$character->id}}/edit"><i class="fas fa-edit"></i></a></h4>
            <h6 class="card-subtitle mb-2 text-muted">My first impression to other characters</h6>
            <p class="card-text">{{$character->impression}}</p>
          </div>
        </div>
        @if($character->backstory)
          <div class="card col-12 col-md mx-2 mb-2 mb-md-0">
            <div class="card-body">
              <h4 class="card-title">Backstory <a href="/character/{{$character->id}}/edit"><i class="fas fa-edit"></i></a></h4>
              <h6 class="card-subtitle mb-2 text-muted">The past I carry with me</h6>
              <p class="card-text">{{$character->backstory}}</p>
            </div>
          </div>
        @endif
      </div>

      <div class="row mt-2">
        <div class="card col-12 col-md mx-2 mb-2 mb-md-0">
          <div class="card-body">
            <h4 class="card-title">My Strengths <a href="/character/{{$character->id}}/edit"><i class="fas fa-edit"></i></a></h4>
            @if($strengths)
              <ul class="list-group list-group-flush">
                @foreach($strengths as $strength)
                  <li class="list-group-item">{{$strength}}</li>
                @endforeach
              </ul>
            @else
              <p class="card-text">This character has no strengths</p>
            @endif
          </div>
        </div>
        <div class="card col-12 col-md mx-2 mb-2 mb-md-0">
          <div class="card-body">
            <h4 class="card-title">My Weaknesses <a href="/character/{{$character->id}}/edit"><i class="fas fa-edit"></i></a></h4>
            @if($weaknesses)
              <ul class="list-group list-group-flush">
                @foreach($weaknesses as $weakness)
                  <li class="list-group-item">{{$weakness}}</li>
                @endforeach
              </ul>
            @else
              <p class="card-text">This character has no weaknesses</p>
            @endif
          </div>
        </div>
      </div>
    </li>
  </ul>

  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete {{$character->name}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-danger">
          Are you sure you want to delete {{$character->name}}?  This action cannot be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a href="/character/{{$character->id}}/delete" class="btn btn-danger">Delete</a>
        </div>
      </div>
    </div>
  </div>
@endsection
