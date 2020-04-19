@extends('layouts.full')

@section('title', 'Novel Voices | Craft Story')
@section('header', isset($story) ? 'Edit Your Story' : 'Craft Your Story')

@section('styles')
  <style media="screen">
    /* Theme boxes */
    .theme {
      width: 400px;
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

    input[type=checkbox] {
      display: none;
    }
  </style>
@endsection

@section('content')
  <form action="{{isset($story) ? "/story/{$story->id}/edit" : '/story'}}" method="post">
    @csrf
    <div class="form-group">
      <input class="form-control" type="text" name="title" placeholder="Title" value="{{old('title') ? old('title') : (isset($story) ? $story->title : '')}}"/>
      @error('title')
        <div class="text-danger">{{$message}}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="descr">What motivates you to create this story?</label>
      <input id="descr" class="form-control" type="text" name="descr" value="{{old('descr') ? old('descr') : (isset($story) ? $story->descr : '')}}"/>
      @error('descr')
        <div class="text-danger">{{$message}}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="characterSelect"><h4>Pick Characters for this Story</h4></label>
      @if(sizeof($characters) > 0)
        <p>You can always add more characters later</p>
      @endif
      @error('characters.*')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <div id="characterSelect" class="d-flex character-list">
        @forelse($characters as $character)
          <div class="character-item">
            <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, {{$character->color1}}, {{$character->color2}})"></div>
            <div class="text-center">{{$character->name}}</div>
            <div class="character-overlay d-flex justify-content-center align-items-center" data-id="{{$character->id}}"><i class="fas fa-check"></i></div>
            <input type="checkbox" name="characters[]" value="{{$character->id}}"/>
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
          <option value="{{$archetype->id}}" {{old('archetype') == $archetype->id ? 'selected' : (isset($story) && $story->archetype_id == $archetype->id ? 'selected' : '')}}>
            {{$archetype->name}}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label><h4>Choose a Theme</h4></label>
      <p>A theme will set the mood for your story</p>
      <input type="hidden" name="theme" value="{{old('theme') ? old('theme') : (isset($story) ? $story->theme_id : '')}}"/>
      @error('theme')
        <div class="text-danger">{{$message}}</div>
      @enderror
      <div class="row">
        @foreach($themes as $theme)
          <div class="col-12 col-sm-6 col-md-4 mb-3 theme {{old('theme') == $theme->id ? 'theme-selected' : (isset($story) && $story->theme_id == $theme->id ? 'theme-selected' : '')}}" data-theme-id="{{$theme->id}}">
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
  <script type="text/javascript">
    $(document).ready(() => {
      @if(old('characters'))
        // preselect all characters from the last submission
        let $this;
        @foreach(old('characters') as $oldCharacterId)
          $this = $('.character-overlay[data-id={{$oldCharacterId}}]');
          $this.addClass('visible');
          $this.next().prop('checked', true);
        @endforeach
      @elseif(isset($story) && $story->characters)
        let $this;
        @foreach($story->characters as $character)
          $this = $('.character-overlay[data-id={{$character->id}}]');
          $this.addClass('visible');
          $this.next().prop('checked', true);
        @endforeach
      @endif

      // set on click for characters
      $('.character-overlay').on('click', function() {
        $(this).toggleClass('visible');
        $(this).next().click();
      });

      // set on click for themes
      $('.theme').on('click', function() {
				$('.theme').removeClass('theme-selected');
				$(this).addClass('theme-selected');
        $('input[name=theme]').val($(this).data('themeId'));
			});
    });
  </script>
@endsection
