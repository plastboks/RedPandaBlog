@layout('account/index')
@section('content')
  <h1>Users on this site</h1>
  <p>
    <ul>
    @foreach ($users as $user)
      <li>{{ $user->username }}, {{ $user->email }}</li>
    @endforeach
    </ul>
  </p>
@endsection
