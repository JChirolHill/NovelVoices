@extends('layouts.full')
@section('title', 'Novel Voices')

@section('styles')
  <style media="screen">
    img {
      width: 100%;
      padding-bottom: 74px;
    }

    p {
      margin: 15px 0;
    }

    #text {
      height: 80vh;
      overflow: scroll;
    }

    #overlay {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-image: linear-gradient(transparent 50%, #e2e7e9);
      z-index: -1;
      border-radius: 10px;
    }

    .row {
      padding-bottom: 74px;
    }
  </style>
@endsection

@section('content')
  <div class="row align-items-center">
    <div class="col col-md-7 mx-auto">
      <div id="overlay"></div>
      <div id="text">

      </div>
      {{-- @foreach($lines as $line)
        {{$line}}
      @endforeach --}}
    </div>
    <div class="d-none d-md-block col-md-5">
      <img src="{{asset('assets/tree.png')}}" alt="Tree">
    </div>
  </div>

@endsection

@section('scripts')
  @if($lines)
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/showdown@1.9.0/dist/showdown.min.js"></script>
    <script type="text/javascript">
      $(document).ready(() => {
        var converter = new showdown.Converter();
        let lines = [];
        @foreach($lines as $line)
          lines.push(converter.makeHtml("{{$line}}"));
        @endforeach
        // console.log(typeof '<h1>Hey</h1>');
        $('#text').html(lines);
        // var converter = new showdown.Converter(),
        //   text      = '# hello, markdown!',
        //   html      = converter.makeHtml(text);
        // // $('#test').html()
        // console.log(html);
      });
    </script>
  @endif
@endsection
