@layout('admin/index')
@section('content')
  <h1>Users on this site</h1>
  <h2>{{ HTML::link('admin/user/new', 'Add new user') }}</h2>
  <p class="message">{{ $status }}</p>
  <p>
    <h2>Active users</h2>
    <ul class="userlist activeusers">
    @foreach ($users as $user)
      <li>
        <ul class="linklist">
          <li class="username">
            {{ $user->username }}, {{ $user->email }}
          </li>
          <li class="edit">
            {{ HTML::link('admin/user/edit/'.$user->id, 'Edit') }}
          </li>
          @unless ($myself->id == $user->id)
          <li class="block">
            {{ HTML::link('admin/user/block/'.$user->id, 'Block') }}
          </li>
          <li class="delete">
            {{ HTML::link('admin/user/delete/'.$user->id, 'Delete') }}
          </li>
          @endunless
        </ul>
      </li>
    @endforeach
    </ul>
  </p>
  <p>
    <h2>Blocked users</h2>
    <ul class="userlist blockedusers">
    @foreach ($blockedUsers as $user)
      <li>
        <ul class="linklist">
          <li class="username">
            {{ $user->username }}, {{ $user->email }}
          </li>
          <li class="edit">
            {{ HTML::link('admin/user/edit/'.$user->id, 'Edit') }}
          </li>
          @unless ($myself->id == $user->id)
          <li class="block">
            {{ HTML::link('admin/user/unblock/'.$user->id, 'Unblock') }}
          </li>
          <li class="delete">
            {{ HTML::link('admin/user/delete/'.$user->id, 'Delete') }}
          </li>
          @endunless
        </ul>
      </li>
    @endforeach
    </ul>
  </p>
@endsection
