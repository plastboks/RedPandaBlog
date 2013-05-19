@layout('admin/index')
@section('content')
  <h1>Users on this site</h1>
  <h2>{{ HTML::link('admin/user/new', 'Add new user') }}</h2>
  <p class="message">{{ $status }}</p>
  <p>
    <h2>Active users</h2>
    <ul>
    @foreach ($users as $user)
      <li>{{ $user->username }}, {{ $user->email }}
          - {{ HTML::link('admin/user/edit/'.$user->id, 'Edit') }}
          @unless ($myself->id == $user->id)
          - {{ HTML::link('admin/user/block/'.$user->id, 'Block') }}
          - {{ HTML::link('admin/user/delete/'.$user->id, 'Delete') }}</li>
          @endunless
    @endforeach
    </ul>
  </p>
  <p>
    <h2>Blocked users</h2>
    <ul>
    @foreach ($blockedUsers as $user)
      <li>{{ $user->username }}, {{ $user->email }}
          - {{ HTML::link('admin/user/edit/'.$user->id, 'Edit') }}
          - {{ HTML::link('admin/user/unblock/'.$user->id, 'Unblock') }}
          - {{ HTML::link('admin/user/delete/'.$user->id, 'Delete') }}</li>
    @endforeach
    </ul>
  </p>
@endsection
