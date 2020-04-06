@extends('layouts.full')

@section('title', 'Novel Voices | Craft Story')
@section('header', 'Craft Your Story')

@section('styles')
  <style media="screen">
    .theme:hover img {
      opacity: 1;
      transform: scale(1.02);
      cursor: pointer;
    }

    .theme img {
      width: 100%;
      opacity: 0.5;
      transition: all 0.5s;
    }

    .theme-selected img {
      opacity: 1;
      transform: scale(1.02);
      cursor: pointer;
    }

    /* SelectPure */
    .select-wrapper {
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
    }
    /* End SelectPure */

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
    <div class="form-group">
      <input class="form-control" type="text" name="title" placeholder="Title">
    </div>
    <div class="form-group">
      <label for="characterSelect"><h4>Pick Characters for this Story</h4></label>
      @if(sizeof($characters) > 0)
        <p>You can always add more characters later</p>
      @endif
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
      <span id="archetypeSelect"></span>
    </div>

    <div class="form-group">
      <label><h4>Choose a Theme</h4></label>
      <p>A theme will set the mood for your story</p>
      <div class="row">
        <div class="col-12 col-sm-6 col-md-4 mb-3 theme" id="theme1">
          <img src="{{ asset('assets/planet.jpg') }}" alt="Planet">
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3 theme">
          <img src="{{ asset('assets/planet.jpg') }}" alt="Planet">
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3 theme">
          <img src="{{ asset('assets/planet.jpg') }}" alt="Planet">
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3 theme">
          <img src="{{ asset('assets/planet.jpg') }}" alt="Planet">
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3 theme">
          <img src="{{ asset('assets/planet.jpg') }}" alt="Planet">
        </div>
      </div>
    </div>
    <div class="form-group text-right">
      <button class="btn btn-my-primary" type="submit">Save My Story</button>
    </div>
  </form>
@endsection

@section('scripts')
  <script src="{{ asset('scripts/bundle.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(() => {
      // get the character and archetype data to populate page
      let archetypeOptions = [];
      getArchetypes().then(response => {
        archetypeOptions = response.map(archetype => {
          return {
            label: archetype.name,
            value: archetype.id.toString()
          }
        });

        // set up select pure
        var archetypeSelect = new SelectPure("#archetypeSelect", {
          options: archetypeOptions,
          multiple: true,
          icon: "fa fa-times"
        });
      });

      // set on click for characters
      $('.character-overlay').on('click', function() {
        // $(this).css('opacity', 1);
        $(this).toggleClass('visible');
      });

      // set on click for themes
      $('.theme').on('click', function() {
				$('.theme').removeClass('theme-selected');
				$(this).addClass('theme-selected');
			});

      // whem form submits
      $('form').submit(function(event) {
        event.preventDefault();

        // get values in archetype dropdown
        console.log(archetypeSelect.value());
      })
    });

    async function getArchetypes() {
      let response = await fetch(`/story_archetypes`);
      return response.json();
    }
  </script>
@endsection
