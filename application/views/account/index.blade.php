@layout('base')
@section('title')
Account
@endsection
@section('secondarynav')
  <li>{{ HTML::link('account/profile', 'My Profile') }}</li>
@endsection
