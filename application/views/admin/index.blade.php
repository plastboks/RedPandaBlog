@layout('base')
@section('title')
Admin Area
@endsection
@section('secondarynav')
  <li>{{ HTML::link('admin/newpost', 'Newpost') }}</li>
@endsection
@section('content')
    <h1>Admin area</h1>
@endsection
