<!DOCTYPE HTML>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <title>Red Panda Blog - @yield('title')</title>
  {{ HTML::style('css/normalize.css') }}
  {{ HTML::style('css/style.css') }}
  {{ HTML::style('css/smoothness/jquery-ui-1.10.3.custom.min.css') }}
  {{ HTML::script('js/jquery-2.0.2.min.js') }}
  {{ HTML::script('js/jquery-ui-1.10.3.custom.min.js') }}
  {{ HTML::script('js/commons.js') }}
</head>
<body>
  <div class="header">
    <h1>{{ HTML::link('/', $s->blogName) }}</h1>
    <div class="search">
      {{ Form::open(array('url' => 'post/query')) }}  
        {{ Form::label('q', 'Search') }}
        {{ Form::text('q', Input::get('q')) }}
        {{ Form::submit('Search') }}
      {{ Form::close() }}
    </div>
    <div class="primarynav">
      <ul>
        @section('primarynav')
        @show
      </ul>
    </div>
    <div class="secondarynav">
      <ul>
        @section('secondarynav')
        @show
      </ul>
    </div>
  </div>
  <div id="content">
    @yield('content')
  </div>
  <div id="sidebar" class="round5">
    @include('sidebar')
  </div>
  <div id="footer">
    <span>{{ $s->footer }}</span>
  </div>
</body>
</html>
