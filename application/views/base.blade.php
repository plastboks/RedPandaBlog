<!DOCTYPE HTML>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
</head>
<body>
  <div class="header">
    <ul>
    @section('navigation')
      <li><a href="#">Home</a></li>
      <li><a href="#">Blog</a></li>
    @yield_section
    </ul>
  </div>
  @yield('content')
</body>
</html>
