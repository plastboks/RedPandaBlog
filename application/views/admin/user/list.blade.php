@layout('admin/index')
@section('content')
  <h1>Users on this site</h1>
  <ul class="thirdmenu">
    <li>{{ HTML::link('admin/user/list', 'Users') }}</li>
    <li>{{ HTML::link('admin/user/blocked', 'Blocked') }}</li>
    <li>{{ HTML::link('admin/user/new', 'Add new') }}</li>
  </ul>
  @if ($status)
  <p class="message">{{ $status }}</p>
  @endif
  <h3>{{ $title }}</h3>
  <div class="tablewrapper round5">
    <table class="list userlist activeusers">
    <thead>
      <th>Username</th>
      <th>Email</th>
      <th>Role</th>
      <th>Action</th>
    </thead>
    <tbody>
    @foreach ($users->results as $user)
      <tr>
        <td class="username">{{ $user->username }}</td>
        <td class="email">{{ $user->email }}</td>
        <td class="role">{{ $p->whatAreYou($user->role) }}</td>
        <td class="action">
          <ul>
            <li class="edit">
              {{ HTML::link('admin/user/edit/'.$user->id, 'Edit') }}
            </li>
            @unless ($myself->id == $user->id)
            <li class="block">
              {{ HTML::link('admin/user/'.$action.'/'.$user->id, ucwords($action)) }}
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
{{ $users->links() }}
@endsection
