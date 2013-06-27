@extends('admin/index')
@section('content')
  <h1>Roles</h1>
  <ul class='thirdmenu'>
    <li>{{ HTML::link('admin/role/list', 'Public') }}</li>
    @if ($p->canI('seeArchivedRoles'))
      <li>{{ HTML::link('admin/role/archived', 'Archived') }}</li>
    @endif
    @if ($p->canI('createRole'))
      <li>{{ HTML::link('admin/role/new', 'Add new') }}</li>
    @endif
  </ul>
  @if ($status)
    <p class='message'>{{ $status }}</p>
  @endif
  <h3>Roles</h3>
  <div class="tablewrapper round5">
    <table class="list postlist publishedposts">
    <thead>
      <th>Title</th>
      <th>Capabilities</th>
      <th>Users</th>
      <th>Action</th>
    </thead>
    <tbody>
    @foreach ($roles as $role)
      <tr>
        <td class="title">{{ $role->name }}</td>
        @if ($role->name == 'admin')
          <td class="count">All</td>
        @else
          <td class="count">{{ count($role->capabilities()->get()) }}</td>
        @endif
        <td class="count">{{ count($role->users()->get()) }}</td>
        <td class="action">
          <ul>
          @unless ($archive)
            @if ($p->canI('updateRole') && ($role->id != 1))
            <li class="edit">{{ HTML::link('admin/role/edit/'.$role->id, 'Edit') }}</li>
            @endif
            @if ($p->canI('deleteRole') && ($role->id != 1))
              @unless (count($role->users()->get()))
                <li class="delete">{{ HTML::link('admin/role/delete/'.$role->id, 'Archive') }}</li>
              @endunless
            @endif
          @else
            @if ($p->canI('undeleteRole'))
                <li class="delete">{{ HTML::link('admin/role/undelete/'.$role->id, 'Unarchive') }}</li>
            @endif
            @if ($p->canI('trueDeleteRole'))
                <li class="delete">{{ HTML::link('admin/role/truedelete/'.$role->id, 'Delete') }}</li>
            @endif
          @endunless
          </ul>
        </td>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
{{ $roles->links() }}
@endsection
