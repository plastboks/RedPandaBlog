@layout('admin/index')
@section('content')
  <h1>Users on this site</h1>
  <h2>{{ HTML::link('admin/newuser', 'Add new user') }}</h2>
  <p class="message">{{ $status }}</p>
  <p>
    <ul>
    @foreach ($users as $user)
      <li>{{ $user->username }}, {{ $user->email }}
          - {{ HTML::link('admin/edituser/'.$user->id, 'Edit') }}</li>
    @endforeach
    </ul>
  </p>
@endsection
