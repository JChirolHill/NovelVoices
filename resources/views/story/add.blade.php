@extends('layouts.full')

@section('title', 'Novel Voices | Craft Story')
@section('header', 'Craft Your Story')

@section('styles')
  <style media="screen">
    /* Theme boxes */
    .theme {
      height: 200px;
      overflow: hidden;
    }

    .theme:hover img {
      opacity: 1;
      transform: scale(1.02);
      cursor: pointer;
    }

    .theme img {
      width: 100%;
      opacity: 0.3;
      transition: all 0.5s;
    }

    .theme-selected img {
      opacity: 1;
      transform: scale(1.02);
      cursor: pointer;
    }
    /* End theme boxes */

    .form-group label {
      margin-bottom: 0;
    }

    .character-item {
      position: relative;
    }

    .character-overlay {
      width: 100px;
      height: 100px;
      background-color: rgba(93, 115, 159, 0.5);
      color: white;
      font-size: 40px;
      position: absolute;
      top: 0;
      left: 0;
      border-radius: 50%;
      opacity: 0;
      transform: rotate(-30deg);
      transition: all 0.5s;
    }

    .character-overlay:hover {
      cursor: pointer;
    }

    .visible {
      opacity: 1;
      transform: rotate(0deg);
    }
  </style>
@endsection

@section('content')
  <form action="/story" method="post">
    @csrf
    <div class="form-group">
      <input class="form-control" type="text" name="title" placeholder="Title"/>
      @error('title')
        <div class="text-danger">{{$message}}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="descr">What motivates you to create this story?</label>
      <input id="descr" class="form-control" type="text" name="descr"/>
      @error('descr')
        <div class="text-danger">{{$message}}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="characterSelect"><h4>Pick Characters for this Story</h4></label>
      @if(sizeof($characters) > 0)
        <p>You can always add more characters later</p>
      @endif
      <input type="hidden" name="characters"/>
      <div id="characterSelect" class="d-flex character-list">
        {{-- <div class="character-item">
          <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, var(--primary), var(--secondary))"></div>
          <div class="text-center">Lia</div>
          <div class="character-overlay d-flex justify-content-center align-items-center"><i class="fas fa-check"></i></div>
        </div>
        <div class="character-item">
          <div class="character-item-circle" style="background-image: linear-gradient(to bottom left, var(--secondary), var(--ternary))"></div>
          <div class="text-center">Aren</div>
          <div class="character-overlay d-flex justify-content-center align-items-center"><i class="fas fa-check"></i></div>
        </div>
        <div class="character-item">
          <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, var(--primary-dark), var(--secondary))"></div>
          <div class="text-center">Evelyn</div>
          <div class="character-overlay d-flex justify-content-center align-items-center"><i class="fas fa-check"></i></div>
        </div>
        <div class="character-item">
          <div class="character-item-circle" style="background-image: linear-gradient(to bottom left, var(--primary-light), var(--ternary))"></div>
          <div class="text-center">Rowan</div>
          <div class="character-overlay d-flex justify-content-center align-items-center"><i class="fas fa-check"></i></div>
        </div> --}}
        @forelse($characters as $character)
          <div class="character-item">
            <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, {{$character->color1}}, {{$character->color2}})"></div>
            <div class="text-center">{{$character->name}}</div>
            <div class="character-overlay d-flex justify-content-center align-items-center" data-id="{{$character->id}}"><i class="fas fa-check"></i></div>
          </div>
        @empty
          You do not have any characters yet.  Craft them once you save this page.
        @endforelse
      </div>
    </div>

    <div class="form-group">
      <label for="archetypeSelect"><h4>Select the Story Archetype</h4></label>
      <p>Not sure what to pick?  Learn more about <a href="/info/story_archetypes" target="_blank">story archetypes</a></p>
      @error('archetype')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <select id="archetypeSelect" class="form-control" name="archetype">
        @foreach($archetypes as $archetype)
          <option value="{{$archetype->id}}">{{$archetype->name}}</option>
        @endforeach
      </select>
      {{-- <span id="archetypeSelect"></span> --}}
    </div>

    <div class="form-group">
      <label><h4>Choose a Theme</h4></label>
      <p>A theme will set the mood for your story</p>
      <input type="hidden" name="theme"/>
      @error('theme')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <div class="row">
        @foreach($themes as $theme)
          <div class="col-12 col-sm-6 col-md-4 mb-3 theme" data-theme-id="{{$theme->id}}">
            <img src="{{ asset("assets/{$theme->url}") }}" alt="{{$theme->url}}">
          </div>
        @endforeach
      </div>
    </div>

    <div class="form-group text-right">
      <button class="btn btn-my-primary" type="submit">Save My Story</button>
    </div>
  </form>
@endsection

@section('scripts')
  {{-- <script src="{{ asset('scripts/bundle.min.js') }}"></script> --}}
  <script type="text/javascript">
    $(document).ready(() => {
      // let archetypeOptions = [];
      // let archetypeSelect;

      // get the character and archetype data to populate page
      // getArchetypes().then(response => {
      //   archetypeOptions = response.map(archetype => {
      //     return {
      //       label: archetype.name,
      //       value: archetype.id.toString()
      //     }
      //   });
      //
      //   // set up select pure
      //   archetypeSelect = new SelectPure("#archetypeSelect", {
      //     options: archetypeOptions,
      //     multiple: true,
      //     icon: "fa fa-times"
      //   });
      // });

      // set on click for characters
      $('.character-overlay').on('click', function() {
        $(this).toggleClass('visible');
      });

      // set on click for themes
      $('.theme').on('click', function() {
				$('.theme').removeClass('theme-selected');
				$(this).addClass('theme-selected');
        $('input[name=theme]').val($(this).data('themeId'));
			});

      // whem form submits
      $('form').submit(function(event) {
        // get all characters selected
        // TODO

        // get values in archetype dropdown
        // $('input[name=archetypes]').val(archetypeSelect.value().map((selection) => {
        //   return Number(selection);
        // }));
      })
    });

    // async function getArchetypes() {
    //   let response = await fetch(`/story_archetypes`);
    //   return response.json();
    // }
  </script>
@endsection
