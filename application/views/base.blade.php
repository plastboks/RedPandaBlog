<!DOCTYPE HTML>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  {{ HTML::style('css/style.css') }}
  {{ HTML::style('css/normalize.css') }}
</head>
<body>
  <div class="header">
    <ul>
    @section('navigation')
      <li>{{ HTML::link_to_route('frontpage', 'Home') }}</li>
      @if (Auth::guest())
        <li>{{ HTML::link('login', 'Login') }}</li>
      @else 
        <li>{{ HTML::link('logout', 'Logout') }}</li>
      @endif
      @if (!Auth::guest())
        <li>{{ HTML::link('account/welcome', 'Account') }}</li>
        <li>{{ HTML::link('admin', 'Admin') }}</li>
      @endif
    @yield_section
    </ul>
  </div>
  @yield('content')
</body>
</html>
