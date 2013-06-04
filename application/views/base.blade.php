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
    <div class="search">
      {{ Form::open('post/q') }}  
        {{ Form::label('q', 'Search') }}
        {{ Form::text('q', Input::get('q')) }}
        {{ Form::submit('Search') }}
      {{ Form::close() }}
    </div>
    <div class="primarynav">
      <ul>
      @section('primarynav')
        <li>{{ HTML::link_to_route('frontpage', 'Home') }}</li>
        @if (!Auth::guest())
          <li>{{ HTML::link('account', 'Account') }}</li>
          <li>{{ HTML::link('admin', 'Admin') }}</li>
        @endif
        @if (Auth::guest())
          <li>{{ HTML::link('login', 'Login') }}</li>
        @else 
          <li>{{ HTML::link('logout', 'Logout') }}</li>
        @endif
      @yield_section
      </ul>
    </div>
    <div class="secondarynav">
      <ul>
        @section('secondarynav')
        @yield_section
      </ul>
    </div>
  </div>
  <div id="content">
    @yield('content')
  </div>
  <div id="footer">
    <span>My awesome laravel blog</span>
  </div>
</body>
</html>
