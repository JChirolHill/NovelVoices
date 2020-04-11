@extends('layouts.full')

@section('title', 'Novel Voices | Animate Character')
@section('header', 'Give Your Character its Voice')

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

    /* SelectPure */
    /* .select-wrapper {
      margin: auto;
      max-width: 600px;
      width: calc(100% - 40px);
    }

    .select-pure__select {
      align-items: center;
      background: #f9f9f8;
      border-radius: 4px;
      border: 1px solid rgba(0, 0, 0, 0.15);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
      box-sizing: border-box;
      color: #363b3e;
      cursor: pointer;
      display: flex;
      font-size: 16px;
      font-weight: 500;
      justify-content: left;
      min-height: 44px;
      padding: 5px 10px;
      position: relative;
      transition: 0.2s;
      width: 100%;
    }

    .select-pure__options {
      border-radius: 4px;
      border: 1px solid rgba(0, 0, 0, 0.15);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
      box-sizing: border-box;
      color: #363b3e;
      display: none;
      left: 0;
      max-height: 221px;
      overflow-y: scroll;
      position: absolute;
      top: 50px;
      width: 100%;
      z-index: 5;
    }

    .select-pure__select--opened .select-pure__options {
      display: block;
    }

    .select-pure__option {
      background: #fff;
      border-bottom: 1px solid #e4e4e4;
      box-sizing: border-box;
      height: 44px;
      line-height: 25px;
      padding: 10px;
    }

    .select-pure__option--selected {
      color: #e4e4e4;
      cursor: initial;
      pointer-events: none;
    }

    .select-pure__option--hidden {
      display: none;
    }

    .select-pure__selected-label {
      background: #5e6264;
      border-radius: 4px;
      color: #fff;
      cursor: initial;
      display: inline-block;
      margin: 5px 10px 5px 0;
      padding: 3px 7px;
    }

    .select-pure__selected-label:last-of-type {
      margin-right: 0;
    }

    .select-pure__selected-label i {
      cursor: pointer;
      display: inline-block;
      margin-left: 7px;
    }

    .select-pure__selected-label i:hover {
      color: #e4e4e4;
    }

    .select-pure__autocomplete {
      background: #f9f9f8;
      border-bottom: 1px solid #e4e4e4;
      border-left: none;
      border-right: none;
      border-top: none;
      box-sizing: border-box;
      font-size: 16px;
      outline: none;
      padding: 10px;
      width: 100%;
    } */
    /* End SelectPure */

    .form-group ul {
      list-style: none;
      margin-top: 1rem;
      border-radius: 5px;
      background-color: var(--primary-light);
      padding: 0 10px;
      box-shadow: 2px 2px 8px var(--ternary-dark);
      display: none;
    }

    .form-group li {
      padding: 3px;
      text-align: center;
      transition: all 0.25s;
    }

    .form-group li:not(:last-child) {
      border-bottom: var(--secondary-dark) solid 1px;
    }

    .form-group li:hover {
      text-decoration: line-through;
      font-style: italic;
      cursor: pointer;
      color: var(--secondary-dark);
    }
  </style>
@endsection

@section('content')
  <form action="/character" method="post">
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
      {{-- <span id="archetypeSelect"></span> --}}
    </div>

    <div class="form-group">
      {{-- {{dd(old('development'))}} --}}
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

      // add strength/weakness - on enter
      // $('.input-list').on('keyup', function(event) {
      //   console.log('in');
      //   if(event.keycode === 13) {
      //     console.log('input clicked');
      //     event.stopPropagation();
      //     event.preventDefault();
      //     let $parent = $(this).parent();
      //     let $list = $parent.next();
      //     let userInput = $(this).val();
      //     $list.val('');
      //     addListItem($list, userInput);
      //   }
      //   return false;
      // });

      // $('form').submit(function(event) {
      //   console.log('submitted');
      //   console.log(event.keycode);
      //   if(event.keycode === 13) {
      //     event.preventDefault();
      //     return false;
      //   }
      // })

      // remove strength/weakness
      $('.form-group').on('click', 'li', function() {
        $(this).remove();
      });

      // let archetypeOptions = [];
      // let strengths = new SelectPure("#strengths", {
      //   options: [ {label: 'hi', value: '1'} ],
      //   multiple: true,
      //   icon: "fa fa-times"
      // });

      // get the character and archetype data to populate page
      // getArchetypes().then(response => {
      //   archetypeOptions = response.map(archetype => {
      //     return {
      //       label: archetype.name,
      //       value: archetype.id.toString()
      //     }
      //   });

        // set up select pure
        // archetypeSelect = new SelectPure("#archetypeSelect", {
        //   options: archetypeOptions,
        //   multiple: true,
        //   icon: "fa fa-times"
        // });
      // });

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
  </script>
@endsection
