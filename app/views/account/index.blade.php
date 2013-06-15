@layout('base')
@section('title')
Account
@endsection
@section('secondarynav')
  <li>{{ HTML::link('account/profile', 'Profile') }}</li>
  <li>{{ HTML::link('account/password', 'Password') }}</li>
  <li>{{ HTML::link('account/myposts', 'My Posts') }}</li>
@endsection
