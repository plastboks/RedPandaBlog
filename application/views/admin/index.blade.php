@layout('base')
@section('title')
Admin Area
@endsection
@section('secondarynav')
  @if ($p->canI('settings'))
  <li>{{ HTML::link('admin/settings', 'Settings') }}</li>
  @endif
  @if ($p->canI('users'))
  <li>{{ HTML::link('admin/user/list', 'Users') }}</li>
  @endif
  @if ($p->canI('roles'))
  <li>{{ HTML::link('admin/role/list', 'Roles') }}</li>
  @endif
  <li>{{ HTML::link('admin/post/list', 'Posts') }}</li>
  <li>{{ HTML::link('admin/category/list', 'Categories') }}</li>
@endsection
@section('content')
    <h1>Admin area</h1>
@endsection
