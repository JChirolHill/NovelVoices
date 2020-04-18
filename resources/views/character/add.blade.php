@extends('layouts.full')

@section('title', 'Novel Voices | Animate Character')
@section('header', isset($character) ? 'Edit Your Character' : 'Give Your Character its Voice')

@section('styles')
  <style media="screen">
    input[type=radio] {
      display: none;
    }

    .radioLabel {
      border-radius: 10px;
      padding: 5px 10px;
      margin: 5px 10px 5px 0;
      background-color: var(--highlight-dark);
      color: white;
      transition: all 0.5s;
    }

    .radioLabel:hover {
      background-color: var(--highlight);
      cursor: pointer;
    }

    .selected {
      background-color: var(--highlight);
      color: white;
    }

    .list-group-item:hover {
      text-decoration: line-through;
      font-style: italic;
      cursor: pointer;
      color: var(--secondary-dark);
    }
  </style>
@endsection

@section('content')
  <form action="{{isset($character) ? "/character/{$character->id}/edit" : '/character'}}" method="post">
    @csrf
    <div class="form-group">
      <input class="form-control" type="text" name="name" placeholder="Give me a name" value="{{old('name') ? old('name') : (isset($character) ? $character->name : '')}}"/>
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
          <option value="{{$archetype->id}}" {{old('archetype') == $archetype->id ? 'selected' : (isset($character) && $character->archetype_id == $archetype->id ? 'selected' : '')}}>
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
      <label class="radioLabel {{old('development') === "0" ? 'selected' : (isset($character) && $character->dynamic === "0" ? 'selected' : '')}}">
        <input type="radio" name="development" value="0" {{old('development') === "0" ? 'checked' : (isset($character) && $character->dynamic === "0" ? 'checked' : '')}}/>Static
      </label>
      <label class="radioLabel {{old('development') === "1" ? 'selected' : (isset($character) && $character->dynamic === "1" ? 'checked' : '')}}">
        <input type="radio" name="development" value="1" {{old('development') === "1" ? 'checked' : (isset($character) && $character->dynamic === "1" ? 'checked' : '')}}/>Dynamic
      </label>
    </div>

    <div class="form-group">
      <label for="hierarchy"><h4>Select My Character Hierarchy</h4></label>
      <p>Not sure what to pick?  Learn more about <a href="/info/hierarchies" target="_blank">character hierarchies</a></p>
      @error('hierarchy')
        <div class="text-danger">{{$message}}</div>
      @enderror
      @foreach($hierarchies as $hierarchy)
        <label class="radioLabel {{old('hierarchy') == $hierarchy->id ? 'selected' : (isset($character) && $character->hierarchy_id == $hierarchy->id ? 'selected' : '')}}">
          <input type="radio" name="hierarchy" value="{{$hierarchy->id}}" {{old('hierarchy') == $hierarchy->id ? 'checked' : (isset($character) && $character->hierarchy_id == $hierarchy->id ? 'checked' : '')}}/>{{$hierarchy->name}}
        </label>
      @endforeach
    </div>

    <div class="form-group">
      <label for="motivation">What drives me?</label>
      @error('motivation')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <textarea id="motivation" class="form-control" name="motivation">{{old('motivation') ? old('motivation') : (isset($character) ? $character->motivation : '')}}</textarea>
    </div>

    <div class="form-group">
      <label for="impression">What is my first impression to other characters or the reader?</label>
      @error('impression')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <textarea id="impression" class="form-control" name="impression">{{old('impression') ? old('impression') : (isset($character) ? $character->impression : '')}}</textarea>
    </div>

    <div class="form-group" id="backstoryGroup">
      <label for="backstory">What is my backstory (if I have one)?</label>
      @error('backstory')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <textarea id="backstory" class="form-control" name="backstory">{{old('backstory') ? old('backstory') : (isset($character) ? $character->backstory : '')}}</textarea>
    </div>

    <div class="row">
      <div class="form-group col-12 col-md-6">
        <label for="strengths">What are my strengths?</label>
        <div class="input-group">
          <input id="strengths" type="text" class="form-control input-list" name="strengths" placeholder="Grit, loyal, funny, fearless, smart..."/>
          <button type="button" class="btn btn-my-primary-dark btn-list">Add Strength</button>
        </div>
        <ul id="strengthsList" class="list-group list-group-flush">
          @if(isset($strengths) && !empty($strengths))
            @foreach($strengths as $strength)
              <li class="list-group-item">{{$strength}}</li>
            @endforeach
          @endif
        </ul>
      </div>

      <div class="form-group col-12 col-md-6">
        <label for="weaknesses">What are my flaws?</label>
        <div class="input-group">
          <input id="weaknesses" type="text" class="form-control input-list" name="weaknesses" placeholder="Arrogant, vengeful, lazy, careless..."/>
          <button type="button" class="btn btn-my-primary-dark btn-list">Add Flaw</button>
        </div>
        <ul id="weaknessesList" class="list-group list-group-flush">
          @if(isset($weaknesses) && !empty($weaknesses))
            @foreach($weaknesses as $weakness)
              <li class="list-group-item">{{$weakness}}</li>
            @endforeach
          @endif
        </ul>
      </div>
    </div>

    <div class="form-group text-right">
      <button class="btn btn-my-primary" type="submit">Save My Character</button>
    </div>
  </form>
@endsection

@section('scripts')
  <script src="{{ asset('scripts/bundle.min.js') }}"></script>
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

      $('form').submit(function(event) {
        // add to the submission all character strengths and weaknesses
        let strengths = [];
        $('#strengthsList li').each(function(index, li) {
          strengths.push(li.innerText);
        });
        $('input[name=strengths]').val(strengths.join(';'));

        let weaknesses = [];
        $('#weaknessesList li').each(function(index, li) {
          weaknesses.push(li.innerText);
        });
        $('input[name=weaknesses]').val(weaknesses.join(';'));
      })

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
        item.classList.add('list-group-item');
        listElement.append(item);
        listElement.css('display', 'block');
      }
    }
  </script>
@endsection
