@unless (Auth::guest())
<ul id="accountmenu">
  <li>{{ HTML::link('account/profile', 'Profile') }}</li>
  <li>{{ HTML::link('account/password', 'Password') }}</li>
  <li>{{ HTML::link('account/myposts', 'My Posts') }}</li>
</ul>
<ul id="adminmenu">
  @if ($p->canI('settings'))
  <li>{{ HTML::link('admin/settings', 'Settings') }}</li>
  @endif
  @if ($p->canI('seeUsers'))
  <li>{{ HTML::link('admin/user/list', 'Users') }}</li>
  @endif
  @if ($p->canI('seeRoles'))
  <li>{{ HTML::link('admin/role/list', 'Roles') }}</li>
  @endif
  <li>{{ HTML::link('admin/post/list', 'Posts') }}</li>
  <li>{{ HTML::link('admin/image/list', 'Images') }}</li>
  <li>{{ HTML::link('admin/category/list', 'Categories') }}</li>
</ul>
@endif
<ul id="loginmenu">
@if (Auth::guest())
  <li>{{ HTML::link('login', 'Login') }}</li>
@else 
  <li>{{ HTML::link('logout', 'Logout') }}</li>
@endif
</ul>
