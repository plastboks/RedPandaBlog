@layout('base')
@section('title')
Admin Area
@endsection
@section('secondarynav')
  <li>{{ HTML::link('admin/post/list', 'Posts') }}</li>
  <li>{{ HTML::link('admin/category/list', 'Categories') }}</li>
  <li>{{ HTML::link('admin/user/list', 'Users') }}</li>
@endsection
@section('content')
    <h1>Admin area</h1>
@endsection
