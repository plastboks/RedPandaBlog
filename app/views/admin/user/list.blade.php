@extends('admin/index')
@section('content')
  <h1>Users on this site</h1>
  <ul class="thirdmenu">
    <li>{{ HTML::link('admin/user/list', 'Users') }}</li>
    <li>{{ HTML::link('admin/user/blocked', 'Blocked') }}</li>
    @if ($p->canI('createUser'))
    <li>{{ HTML::link('admin/user/new', 'Add new') }}</li>
    @endif
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
      <th>Posts</th>
      <th>Role</th>
      <th>Action</th>
    </thead>
    <tbody>
    @foreach ($users as $user)
      <tr>
        <td class="username">{{ $user->username }}</td>
        <td class="email">{{ $user->email }}</td>
        <td class="role">{{ count($user->posts()->get()) }}</td>
        <td class="role">{{ $user->role()->name }}</td>
        <td class="action">
          @unless ($user->id == Auth::user()->id)
          <ul>
            @if ($p->canI('updateUser'))
            <li class="edit">
              {{ HTML::link('admin/user/edit/'.$user->id, 'Edit') }}
            </li>
            @endif
            @unless ($myself->id == $user->id)
              @if ($p->canI('blockUser') && $p->canI('unblockUser'))
              <li class="block">
                {{ HTML::link('admin/user/'.$action.'/'.$user->id, ucwords($action)) }}
              </li>
              @endif
            @if ($p->canI('deleteUser') && !count($user->posts()->get()))
            <li class="delete">
              {{ HTML::link('admin/user/delete/'.$user->id, 'Delete') }}
            </li>
            @endif
            @endunless
          </ul>
          @endunless
        </td>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
{{ $users->links() }}
@endsection
