@layout('base')
@section('title')
Account
@endsection
@section('secondarynav')
  <li>{{ HTML::link('account/profile', 'My Profile') }}</li>
  <li>{{ HTML::link('account/list', 'Users on site') }}</li>
@endsection
