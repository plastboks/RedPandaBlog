@layout('base')
@section('title')
Admin Area
@endsection
@section('secondarynav')
  <li>{{ HTML::link('admin/posts', 'Posts') }}</li>
  <li>{{ HTML::link('admin/users', 'Users') }}</li>
@endsection
@section('content')
    <h1>Admin area</h1>
@endsection
