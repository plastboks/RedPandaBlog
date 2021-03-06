@extends('admin/index')
@section('content')
  <h1>Images</h1>
  <ul class="thirdmenu">
    <li>{{ HTML::link('admin/image/list', 'Public') }}</li>
    @if ($p->canI('seeArchivedImages'))
      <li>{{ HTML::link('admin/image/archived', 'Archived')}}</li>
    @endif
    @if ($p->canI('createImage'))
      <li>{{ HTML::link('admin/image/new', 'Add new') }}</li>
    @endif
  </ul>
  <h3>Images</h3>
  <div class="tablewrapper round5">
    <table class="list imagelist publishedimages">
    <thead>
        <th>Title</th>
        <th>Uploaded</th>
        <th>In posts</th>
        <th>Action</th>
    </thead>
    <tbody>
    @foreach ($images as $image)
      <tr>
        <td class="linklist">
            {{ HTML::link('image/view/'.$image->id, $image->title) }}
        </td>
        <td class="date">{{ $image->created_at }}</td>
        <td class="count">{{ count($image->posts()->get()) }}</td>
        <td class="action">
          <ul>
          @unless ($archived)
            @if ($p->canI('updateImage'))
            <li class="edit">
              {{ HTML::link('admin/image/edit/'.$image->id, 'Edit') }}
            </li>
            @endif
            @if (($p->canI('deleteImage')) && !(count($image->posts()->get())))
            <li class="delete">
              {{ HTML::link('admin/image/delete/'.$image->id, 'Archive') }}
            </li>
            @endif
          @else
            @if ($p->canI('undeleteImage'))
            <li class="delete">
              {{ HTML::link('admin/image/undelete/'.$image->id, 'Unarchive') }}
            </li>
            @endif
            @if ($p->canI('trueDeleteImage'))
            <li class="delete">
              {{ HTML::link('admin/image/truedelete/'.$image->id, 'Delete') }}
            </li>
            @endif
          @endunless
          </ul>
        </ul>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
{{ $images->links() }}
@endsection
