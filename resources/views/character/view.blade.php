@extends('layouts.full')

@section('title', 'Novel Voices | View Character')
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
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <h4>My Character Archetype: {{$character->archetype->name}} <i class="fas fa-edit"></i></h4>
      Read more about <a href="/info/character_archetypes" target="_blank">character archetypes.</a>
    </li>
    <li class="list-group-item">
      <h4>I am a {{$character->dynamic ? 'Dynamic' : 'Static'}} character <i class="fas fa-edit"></i></h4>
      Read more about types of <a href="/info/dynamic_static" target="_blank">character development</a>.
    </li>
    <li class="list-group-item">
      <h4>I am a {{$character->hierarchy->name}} character <i class="fas fa-edit"></i></h4>
      Read more about <a href="/info/hierarchies" target="_blank">character hierarchies</a>.
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="card col-12 col-md mx-2 mb-2 mb-md-0">
          <div class="card-body">
            <h4 class="card-title">Motivation <i class="fas fa-edit"></i></h4>
            <h6 class="card-subtitle mb-2 text-muted">What I want and what drives me</h6>
            <p class="card-text">{{$character->motivation}}</p>
          </div>
        </div>
        <div class="card col-12 col-md mx-2 mb-2 mb-md-0">
          <div class="card-body">
            <h4 class="card-title">First Impression <i class="fas fa-edit"></i></h4>
            <h6 class="card-subtitle mb-2 text-muted">My first impression to other characters</h6>
            <p class="card-text">{{$character->impression}}</p>
          </div>
        </div>
        @if($character->backstory)
          <div class="card col-12 col-md mx-2 mb-2 mb-md-0">
            <div class="card-body">
              <h4 class="card-title">Backstory <i class="fas fa-edit"></i></h4>
              <h6 class="card-subtitle mb-2 text-muted">The past I carry with me</h6>
              <p class="card-text">{{$character->backstory}}</p>
            </div>
          </div>
        @endif
      </div>

      <div class="row mt-2">
        <div class="card col-12 col-md mx-2 mb-2 mb-md-0">
          <div class="card-body">
            <h4 class="card-title">My Strengths <i class="fas fa-edit"></i></h4>
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
            <h4 class="card-title">My Weaknesses <i class="fas fa-edit"></i></h4>
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
  {{-- <form action="/character" method="post">
    @csrf
    <div class="form-group">
      <input class="form-control" type="text" name="name" placeholder="Give me a name" value="{{old('name')}}"/>
      @error('name')
        <div class="text-danger">{{$message}}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="archetypeSelect"><h4>Select My Character Archetype</h4></label>
      <p>Not sure what to pick?  Learn more about <a href="/info/character_archetypes" target="_blank">character archetypes</a></p>
      @error('archetype')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <select id="archetypeSelect" class="form-control" name="archetype">
        @foreach($archetypes as $archetype)
          <option value="{{$archetype->id}}" {{old('archetype') == $archetype->id ? 'selected' : ''}}>
            {{$archetype->name}}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="development"><h4>Select My Character Development</h4></label>
      <p>Not sure what to pick?  Learn more about <a href="/info/dynamic_static" target="_blank">static and dynamic characters</a></p>
      @error('development')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <label class="radioLabel {{old('development') === "0" ? 'selected' : ''}}">
        <input type="radio" name="development" value="0" {{old('development') === "0" ? 'checked' : ''}}/>Static
      </label>
      <label class="radioLabel {{old('development') === "1" ? 'selected' : ''}}">
        <input type="radio" name="development" value="1" {{old('development') === "1" ? 'checked' : ''}}/>Dynamic
      </label>
    </div>

    <div class="form-group">
      <label for="hierarchy"><h4>Select My Character Hierarchy</h4></label>
      <p>Not sure what to pick?  Learn more about <a href="/info/hierarchies" target="_blank">character hierarchies</a></p>
      @error('hierarchy')
        <div class="text-danger">{{$message}}</div>
      @enderror
      @foreach($hierarchies as $hierarchy)
        <label class="radioLabel {{old('hierarchy') == $hierarchy->id ? 'selected' : ''}}">
          <input type="radio" name="hierarchy" value="{{$hierarchy->id}}" {{old('hierarchy') == $hierarchy->id ? 'checked' : ''}}/>{{$hierarchy->name}}
        </label>
      @endforeach
    </div>

    <div class="form-group">
      <label for="motivation">What drives me?</label>
      @error('motivation')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <textarea id="motivation" class="form-control" name="motivation">{{old('motivation')}}</textarea>
    </div>

    <div class="form-group">
      <label for="impression">What is my first impression to other characters or the reader?</label>
      @error('impression')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <textarea id="impression" class="form-control" name="impression">{{old('impression')}}</textarea>
    </div>

    <div class="form-group" id="backstoryGroup">
      <label for="backstory">What is my backstory (if I have one)?</label>
      @error('backstory')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <textarea id="backstory" class="form-control" name="backstory">{{old('backstory')}}</textarea>
    </div>

    <div class="row">
      <div class="form-group col-12 col-md-6">
        <label for="strengths">What are my strengths?</label>
        <div class="input-group">
          <input id="strengths" type="text" class="form-control input-list" name="strengths" placeholder="Grit, loyal, funny, fearless, smart..."/>
          <button type="button" class="btn btn-my-primary-dark btn-list">Add Strength</button>
        </div>
        <ul></ul>
      </div>

      <div class="form-group col-12 col-md-6">
        <label for="weaknesses">What are my flaws?</label>
        <div class="input-group">
          <input id="weaknesses" type="text" class="form-control input-list" name="weaknesses" placeholder="Arrogant, vengeful, lazy, careless..."/>
          <button type="button" class="btn btn-my-primary-dark btn-list">Add Flaw</button>
        </div>
        <ul></ul>
      </div>
    </div>

    <div class="form-group text-right">
      <button class="btn btn-my-primary" type="submit">Save My Character</button>
    </div>
  </form> --}}
@endsection

@section('scripts')
  {{-- <script src="{{ asset('scripts/bundle.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      updateBackstoryDisplay();

      // add strength/weakness - on button click
      $('.btn-list').on('click', function() {
        let $list = $(this).parent().next();
        let $input = $(this).prev();
        let userInput = $input.val();
        $input.val('');
        addListItem($list, userInput);
      });

      // remove strength/weakness
      $('.form-group').on('click', 'li', function() {
        $(this).remove();
      });

      // logic to visually display which radio button selected
      $('input[type=radio]').on('change', function() {
        let $parent = $(this).parent();
        $parent.parent().find('.radioLabel').removeClass('selected');
        $parent.addClass('selected');

        updateBackstoryDisplay();
      });
    });

    function updateBackstoryDisplay() {
      // only show backstory if not an 'extra' character
      let selectedHierarchy = $('input[name=hierarchy]:checked').val();
      if(typeof selectedHierarchy === 'undefined' || selectedHierarchy == {{$extraHierarchy->id}}) {
        $('#backstoryGroup').css('display', 'none');
      }
      else {
        $('#backstoryGroup').css('display', 'block');
      }
    }

    function addListItem(listElement, userInput) {
      if(userInput != '') { // the idiot check
        let item = document.createElement('li');
        item.innerText = userInput;
        listElement.append(item);
        listElement.css('display', 'block');
      }
    }
  </script> --}}
@endsection
