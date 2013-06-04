@layout('admin/index')
@section('content')
  <h1>Users on this site</h1>
  <h2>{{ HTML::link('admin/user/new', 'Add new user') }}</h2>
  @if ($status)
  <p class="message">{{ $status }}</p>
  @endif
  <h3>Active users</h3>
  <div class="tablewrapper round5">
    <table class="list userlist activeusers">
    <thead>
      <th>Username</th>
      <th>Email</th>
      <th>Created</th>
      <th>Action</th>
    </thead>
    <tbody>
    @foreach ($users as $user)
      <tr>
        <td class="username">{{ $user->username }}</td>
        <td class="email">{{ $user->email }}</td>
        <td class="date">{{ $user->created_at }}</td>
        <td class="action">
          <ul>
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
        </td>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
  @if ($blockedUsers)
  <h3>Blocked users</h3>
  <div class="tablewrapper round5">
    <table class="list userlist blockedusers">
    <thead>
      <th>Username</th>
      <th>Email</th>
      <th>Created</th>
      <th>Action</th>
    </thead>
    @foreach ($blockedUsers as $user)
      <tr>
        <td class="username">{{ $user->username }}</td>
        <td class="email">{{ $user->email }}</td>
        <td class="date">{{ $user->created_at }}</td>
        <td class="action">
          <ul>
            <li class="edit">
              {{ HTML::link('admin/user/edit/'.$user->id, 'Edit') }}
            </li>
            @unless ($myself->id == $user->id)
            <li class="unblock">
              {{ HTML::link('admin/user/unblock/'.$user->id, 'Unblock') }}
            </li>
            <li class="delete">
              {{ HTML::link('admin/user/delete/'.$user->id, 'Delete') }}
            </li>
            @endunless
          </ul>
        </td>
      </tr>
    @endforeach
    </table>
  </div>
  @endif
@endsection
