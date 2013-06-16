<!DOCTYPE HTML>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <title>Red Panda Blog - @yield('title')</title>
  {{ HTML::style('css/style.css') }}
  {{ HTML::style('css/normalize.css') }}
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
        @if (!Auth::guest())
          <li>{{ HTML::link('account', 'Account') }}</li>
          <li>{{ HTML::link('admin', 'Admin') }}</li>
        @endif
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
  <div id="footer">
    <span>{{ $s->footer }}</span>
    @if (Auth::guest())
      {{ HTML::link('login', 'Login') }}
    @else 
      {{ HTML::link('logout', 'Logout') }}
    @endif
  </div>
</body>
</html>
